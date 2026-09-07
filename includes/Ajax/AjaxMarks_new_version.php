<?php
defined('ABSPATH') || exit;
class ESP_Ajax_Marks {

    public static function register(): void {
        add_action('wp_ajax_esp_save_marks', [self::class, 'save']);
        add_action('wp_ajax_esp_submit_marks', [self::class, 'submit']);
    }

    public static function save(): void {
        esp_verify_nonce();

        global $wpdb;
        $campus = ESP_CampusContext::id();
        $exam_id = absint($_POST['exam_id'] ?? 0);
        $class_id = absint($_POST['class_id'] ?? 0);
        $subject_id = absint($_POST['subject_id'] ?? 0);
        $rows = (array)($_POST['data'] ?? []);

        // Support legacy marks[student_id] form format
        if (empty($rows) && !empty($_POST['marks']) && is_array($_POST['marks'])) {
            foreach ($_POST['marks'] as $st_id => $ob_marks) {
                $rows[] = [
                    'student_id' => absint($st_id),
                    'subject_id' => $subject_id,
                    'obtained_marks' => $ob_marks,
                    'remarks' => '',
                ];
            }
        }

        if (!$exam_id || empty($rows)) {
            wp_send_json_error(['message' => esc_html__('Invalid marks payload or missing exam data.', 'exam-system-pro')], 400);
        }

        // If campus context is 0, attempt fallback from exam record
        if (!$campus) {
            $exam_campus = (int)$wpdb->get_var($wpdb->prepare("SELECT campus_id FROM {$wpdb->prefix}esp_exams WHERE id=%d", $exam_id));
            if ($exam_campus > 0) {
                $campus = $exam_campus;
                ESP_CampusContext::set($campus);
            }
        }

        if (!$campus) {
            wp_send_json_error(['message' => esc_html__('Active campus could not be determined.', 'exam-system-pro')], 400);
        }

        $exam_row = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_exams WHERE id=%d AND campus_id=%d",
            $exam_id,
            $campus
        ), ARRAY_A);

        if (!$exam_row) {
            wp_send_json_error(['message' => esc_html__('Selected exam was not found in the active campus.', 'exam-system-pro')], 400);
        }

        if (!$class_id) {
            wp_send_json_error(['message' => esc_html__('Please select a class.', 'exam-system-pro')], 400);
        }

        $schedule = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_exam_schedules WHERE exam_id=%d AND class_id=%d AND campus_id=%d",
            $exam_id,
            $class_id,
            $campus
        ));

        if (!$schedule) {
            wp_send_json_error(['message' => esc_html__('The selected exam does not have a schedule for the selected class.', 'exam-system-pro')], 400);
        }

        $session = ESP_SessionContext::id();

        $is_admin = current_user_can('manage_options');
        $teacher_id = 0;

        if (!$is_admin) {
            $teacher_id = (int)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_teachers WHERE wp_user_id=%d AND campus_id=%d AND status=1",
                get_current_user_id(),
                $campus
            ));

            if (!$teacher_id) {
                wp_send_json_error(['message' => esc_html__('Teacher profile not found or inactive for this campus.', 'exam-system-pro')], 403);
            }
        }

        $user_id = get_current_user_id();
        $now = current_time('mysql');
        $saved = 0;
        $active_grant_id = 0;

        // Collect all distinct subject IDs in the payload
        $subject_ids = array_values(array_unique(array_filter(array_map(static fn($r) => absint($r['subject_id'] ?? $subject_id), $rows))));

        foreach ($subject_ids as $sub_id) {
            if (!$is_admin) {
                $allocated = (bool)$wpdb->get_var($wpdb->prepare(
                    "SELECT id FROM {$wpdb->prefix}esp_allocations WHERE campus_id=%d AND session_id=%d AND class_id=%d AND subject_id=%d AND teacher_id=%d",
                    $campus,
                    $session,
                    $class_id,
                    $sub_id,
                    $teacher_id
                ));

                if (!$allocated) {
                    continue; // Skip unauthorized subjects
                }

                // Check lock status for this subject
                $is_locked = (bool)$wpdb->get_var($wpdb->prepare(
                    "SELECT id FROM {$wpdb->prefix}esp_marks WHERE campus_id=%d AND exam_id=%d AND subject_id=%d AND locked_at IS NOT NULL LIMIT 1",
                    $campus,
                    $exam_id,
                    $sub_id
                ));

                if ($is_locked) {
                    $grant = (int)$wpdb->get_var($wpdb->prepare(
                        "SELECT id FROM {$wpdb->prefix}esp_mark_resubmits 
                         WHERE campus_id=%d AND session_id=%d AND exam_id=%d AND class_id=%d AND subject_id=%d AND teacher_id=%d AND used_at IS NULL",
                        $campus,
                        $session,
                        $exam_id,
                        $class_id,
                        $sub_id,
                        $teacher_id
                    ));

                    if (!$grant) {
                        wp_send_json_error(['message' => esc_html__('This marks sheet is locked. Please request resubmission from an administrator.', 'exam-system-pro')], 403);
                    }

                    $active_grant_id = $grant;
                }
            }
        }

        // Cache total marks per subject
        $subject_totals = [];

        foreach ($rows as $row) {
            $student_id = absint($row['student_id'] ?? 0);
            $sub_id = absint($row['subject_id'] ?? $subject_id);
            $raw_val = $row['obtained_marks'] ?? '';
            $remarks = sanitize_text_field($row['remarks'] ?? '');

            if (!$student_id || !$sub_id) {
                continue;
            }

            // Verify teacher allocation
            if (!$is_admin) {
                $allocated = (bool)$wpdb->get_var($wpdb->prepare(
                    "SELECT id FROM {$wpdb->prefix}esp_allocations WHERE campus_id=%d AND session_id=%d AND class_id=%d AND subject_id=%d AND teacher_id=%d",
                    $campus,
                    $session,
                    $class_id,
                    $sub_id,
                    $teacher_id
                ));
                if (!$allocated) {
                    continue;
                }
            }

            // Verify student is in active campus
            $valid_student = (bool)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_students WHERE id=%d AND campus_id=%d AND status=1",
                $student_id,
                $campus
            ));

            if (!$valid_student) {
                continue;
            }

            if (!isset($subject_totals[$sub_id])) {
                $subject_totals[$sub_id] = (float)$wpdb->get_var($wpdb->prepare(
                    "SELECT total_marks FROM {$wpdb->prefix}esp_subjects WHERE id=%d AND campus_id=%d",
                    $sub_id,
                    $campus
                ));
            }

            $max_marks = $subject_totals[$sub_id] ?: 100.0;
            $obtained = is_numeric($raw_val) ? max(0, min((float)$raw_val, $max_marks)) : 0.0;

            $existing = $wpdb->get_row($wpdb->prepare(
                "SELECT id, locked_at FROM {$wpdb->prefix}esp_marks WHERE campus_id=%d AND exam_id=%d AND student_id=%d AND subject_id=%d",
                $campus,
                $exam_id,
                $student_id,
                $sub_id
            ), ARRAY_A);

            if ($existing) {
                $res = $wpdb->update(
                    $wpdb->prefix . 'esp_marks',
                    [
                        'obtained_marks' => $obtained,
                        'remarks' => $remarks,
                        'submitted_by' => $user_id,
                        'updated_at' => $now,
                    ],
                    [
                        'id' => (int)$existing['id'],
                        'campus_id' => $campus,
                    ]
                );
                if ($res !== false) {
                    $saved++;
                }
            } else {
                $res = $wpdb->insert(
                    $wpdb->prefix . 'esp_marks',
                    [
                        'campus_id' => $campus,
                        'exam_id' => $exam_id,
                        'student_id' => $student_id,
                        'subject_id' => $sub_id,
                        'obtained_marks' => $obtained,
                        'remarks' => $remarks,
                        'submitted_by' => $user_id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
                if ($res !== false) {
                    $saved++;
                }
            }
        }

        // If saved under a resubmit grant, mark it as used
        if ($active_grant_id && $saved > 0) {
            $wpdb->update(
                $wpdb->prefix . 'esp_mark_resubmits',
                ['used_at' => $now],
                ['id' => $active_grant_id, 'used_at' => null]
            );
        }

        wp_send_json_success([
            'saved' => $saved,
            'message' => sprintf(esc_html__('Successfully saved %d marks records.', 'exam-system-pro'), $saved),
            'resubmit_used' => (bool)$active_grant_id,
        ]);
    }

    public static function submit(): void {
        esp_verify_nonce();

        global $wpdb;
        $campus = ESP_CampusContext::id();
        $exam_id = absint($_POST['exam_id'] ?? 0);
        $class_id = absint($_POST['class_id'] ?? 0);
        $subject_id = absint($_POST['subject_id'] ?? 0);

        if (!$campus || !$exam_id || !$subject_id) {
            wp_send_json_error(['message' => esc_html__('Missing required parameters for marks submission.', 'exam-system-pro')], 400);
        }

        if (!$class_id) {
            wp_send_json_error(['message' => esc_html__('Please select a class.', 'exam-system-pro')], 400);
        }

        $exam_row = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_exams WHERE id=%d AND campus_id=%d",
            $exam_id,
            $campus
        ));

        if (!$exam_row) {
            wp_send_json_error(['message' => esc_html__('Selected exam was not found.', 'exam-system-pro')], 400);
        }

        $schedule = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_exam_schedules WHERE exam_id=%d AND class_id=%d AND campus_id=%d",
            $exam_id,
            $class_id,
            $campus
        ));

        if (!$schedule) {
            wp_send_json_error(['message' => esc_html__('The selected exam does not have a schedule for the selected class.', 'exam-system-pro')], 400);
        }

        $session = ESP_SessionContext::id();

        $is_admin = current_user_can('manage_options');
        $teacher_id = 0;

        if (!$is_admin) {
            $teacher_id = (int)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_teachers WHERE wp_user_id=%d AND campus_id=%d AND status=1",
                get_current_user_id(),
                $campus
            ));

            if (!$teacher_id) {
                wp_send_json_error(['message' => esc_html__('Teacher profile not found.', 'exam-system-pro')], 403);
            }

            $allocated = (bool)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_allocations WHERE campus_id=%d AND session_id=%d AND class_id=%d AND subject_id=%d AND teacher_id=%d",
                $campus,
                $session,
                $class_id,
                $subject_id,
                $teacher_id
            ));

            if (!$allocated) {
                wp_send_json_error(['message' => esc_html__('This subject is not allocated to you.', 'exam-system-pro')], 403);
            }
        }

        $now = current_time('mysql');
        $user_id = get_current_user_id();

        // Lock all existing marks for this exam/class/subject scope
        $sql = "UPDATE {$wpdb->prefix}esp_marks m 
                INNER JOIN {$wpdb->prefix}esp_students st ON st.id=m.student_id 
                INNER JOIN {$wpdb->prefix}esp_exams e ON e.id=m.exam_id 
                SET m.locked_at=%s, m.submitted_at=%s, m.submitted_by=%d 
                WHERE m.exam_id=%d AND m.subject_id=%d AND m.campus_id=%d 
                AND st.class_id=%d AND st.session_id=%d AND st.campus_id=%d";

        $wpdb->query($wpdb->prepare(
            $sql,
            $now,
            $now,
            $user_id,
            $exam_id,
            $subject_id,
            $campus,
            $class_id,
            $session,
            $campus
        ));

        wp_send_json_success([
            'message' => esc_html__('Marks submitted and sheet locked successfully.', 'exam-system-pro'),
            'is_locked' => true,
        ]);
    }
}
