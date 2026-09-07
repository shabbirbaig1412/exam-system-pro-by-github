<?php

defined('ABSPATH') || exit;

class ESP_Ajax_MarksLoader {

    public static function register(): void {
        add_action('wp_ajax_esp_load_marks', [self::class, 'load']);
    }

    public static function load(): void {
        esp_verify_nonce();

        $exam = absint($_POST['exam'] ?? $_POST['exam_id'] ?? 0);
        $class = absint($_POST['class'] ?? $_POST['class_id'] ?? 0);
        $subject = absint($_POST['subject'] ?? $_POST['subject_id'] ?? 0);

        if (!$exam || !$subject) {
            wp_send_json_error(['message' => esc_html__('Please select both an Exam and a Subject.', 'exam-system-pro')], 400);
        }

        global $wpdb;
        $campus = ESP_CampusContext::id();
        $session = ESP_SessionContext::id();

        if (!$campus) {
            wp_send_json_error(['message' => esc_html__('No active campus selected.', 'exam-system-pro')], 400);
        }

        // Validate exam exists in active campus
        $exam_row = $wpdb->get_row($wpdb->prepare(
            "SELECT id, exam_name FROM {$wpdb->prefix}esp_exams WHERE id=%d AND campus_id=%d",
            $exam,
            $campus
        ), ARRAY_A);

        if (!$exam_row) {
            wp_send_json_error(['message' => esc_html__('Selected exam was not found in the active campus.', 'exam-system-pro')], 400);
        }

        // Validate class is provided and exam has schedule for that class
        if (!$class) {
            wp_send_json_error(['message' => esc_html__('Please select a class.', 'exam-system-pro')], 400);
        }

        $schedule = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_exam_schedules WHERE exam_id=%d AND class_id=%d AND campus_id=%d AND status=1",
            $exam,
            $class,
            $campus
        ));

        if (!$schedule) {
            wp_send_json_error(['message' => esc_html__('The selected exam does not have a schedule for the selected class.', 'exam-system-pro')], 400);
        }

        // Validate subject exists in active campus
        $subject_row = $wpdb->get_row($wpdb->prepare(
            "SELECT id, subject_name, total_marks, passing_marks FROM {$wpdb->prefix}esp_subjects WHERE id=%d AND campus_id=%d",
            $subject,
            $campus
        ), ARRAY_A);

        if (!$subject_row) {
            wp_send_json_error(['message' => esc_html__('Selected subject was not found in the active campus.', 'exam-system-pro')], 400);
        }

        // Teacher capability and allocation verification
        $is_admin = current_user_can('manage_options');
        $teacher = 0;
        $resubmit_active = false;

        if (!$is_admin) {
            $teacher = (int)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_teachers WHERE wp_user_id=%d AND campus_id=%d AND status=1",
                get_current_user_id(),
                $campus
            ));

            if (!$teacher) {
                wp_send_json_error(['message' => esc_html__('Teacher profile not found or inactive for this campus.', 'exam-system-pro')], 403);
            }

            $allocated = (bool)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_allocations WHERE campus_id=%d AND session_id=%d AND class_id=%d AND subject_id=%d AND teacher_id=%d",
                $campus,
                $session,
                $class,
                $subject,
                $teacher
            ));

            if (!$allocated) {
                wp_send_json_error(['message' => esc_html__('This subject is not allocated to you for this class and session.', 'exam-system-pro')], 403);
            }
        }

        // Check lock status and resubmit permission
        $locked_count = (int)$wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) 
             FROM {$wpdb->prefix}esp_marks m 
             INNER JOIN {$wpdb->prefix}esp_students st ON st.id=m.student_id
             WHERE m.exam_id=%d AND m.subject_id=%d AND m.campus_id=%d 
             AND st.class_id=%d AND st.session_id=%d AND st.campus_id=%d
             AND m.locked_at IS NOT NULL",
            $exam,
            $subject,
            $campus,
            $class,
            $session,
            $campus
        ));

        $resubmit_grant_id = 0;
        if ($teacher) {
            $resubmit_grant_id = (int)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_mark_resubmits 
                 WHERE campus_id=%d AND session_id=%d AND exam_id=%d AND class_id=%d AND subject_id=%d AND teacher_id=%d AND used_at IS NULL",
                $campus,
                $session,
                $exam,
                $class,
                $subject,
                $teacher
            ));
        }

        $is_locked = false;
        if ($locked_count > 0) {
            if ($is_admin) {
                $is_locked = false; // Admins can always edit
            } elseif ($resubmit_grant_id > 0) {
                $is_locked = false;
                $resubmit_active = true;
            } else {
                $is_locked = true;
            }
        }

        $repo = new ESP_MarksRepository();
        $rows = $repo->loadSheet($exam, $class, $subject);

        ob_start();
        ESP_View::render('admin/partials/marks-sheet', [
            'rows' => $rows,
            'is_locked' => $is_locked,
            'total_marks' => (float)$subject_row['total_marks'],
            'passing_marks' => (float)$subject_row['passing_marks'],
            'subject_name' => $subject_row['subject_name'],
        ]);
        $html = ob_get_clean();

        wp_send_json_success([
            'html' => $html,
            'count' => count($rows),
            'is_locked' => $is_locked,
            'resubmit_active' => $resubmit_active,
            'can_resubmit_request' => $is_locked && !$is_admin && !$resubmit_active,
            'total_marks' => (float)$subject_row['total_marks'],
            'passing_marks' => (float)$subject_row['passing_marks'],
            'subject_name' => $subject_row['subject_name'],
            'exam_name' => $exam_row['exam_name'],
            'class_id' => $class,
        ]);
    }
}
