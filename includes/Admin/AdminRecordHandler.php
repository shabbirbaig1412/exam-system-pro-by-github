<?php

defined('ABSPATH') || exit;

class ESP_AdminRecordHandler {

    public static function register(): void {
        add_action('admin_post_esp_save_record', [self::class, 'save']);
        add_action('admin_post_esp_delete_record', [self::class, 'delete']);
        add_action('admin_post_esp_generate_results', [self::class, 'generate_results']);
        add_action('admin_post_esp_promote_student', [self::class, 'promote_student']);
    }

    public static function save(): void {
        self::authorize();

        global $wpdb;
        $entity = sanitize_key($_POST['entity'] ?? '');
        if ($entity === 'settings') {
            update_option('esp_school_settings', [
                'school_name' => sanitize_text_field($_POST['school_name'] ?? ''),
                'school_code' => sanitize_text_field($_POST['school_code'] ?? ''),
                'address' => sanitize_textarea_field($_POST['address'] ?? ''),
                'phone' => sanitize_text_field($_POST['phone'] ?? ''),
                'email' => sanitize_email($_POST['email'] ?? ''),
                'website' => esc_url_raw($_POST['website'] ?? ''),
            ]);
            self::redirect('updated');
        }
        $definitions = self::definitions();
        if (!isset($definitions[$entity])) {
            wp_die(esc_html__('Invalid record type.', 'exam-system-pro'));
        }

        $definition = $definitions[$entity];
        $data = [];
        foreach ($definition['fields'] as $field => $sanitizer) {
            $value = wp_unslash($_POST[$field] ?? '');
            // Status fields are not exposed on the basic record forms, so new
            // records must default to active rather than being saved as 0.
            if (in_array($field, ['status', 'is_active'], true) && $value === '') {
                $data[$field] = 1;
            } else {
                $data[$field] = $sanitizer === 'int' ? absint($value) : call_user_func($sanitizer, $value);
            }
        }

        // Operational records inherit the global session; clients cannot
        // switch session by tampering with a hidden/request value.
        if (in_array($entity, ['students', 'allocations'], true)) {
            $data['session_id'] = ESP_SessionContext::id();
        }

        if (in_array($entity, ['classes', 'teachers', 'students', 'subjects', 'exams', 'exam_schedules', 'marks', 'allocations'], true)) {
            $data['campus_id'] = ESP_CampusContext::id();
        }

        if (in_array($entity, ['classes', 'teachers', 'students', 'subjects', 'exams', 'exam_schedules', 'marks', 'allocations'], true) && !$data['campus_id']) {
            self::redirect('error', __('Select a valid active campus first.', 'exam-system-pro'));
        }
        foreach (['exam_id' => 'esp_exams', 'class_id' => 'esp_classes', 'subject_id' => 'esp_subjects', 'teacher_id' => 'esp_teachers'] as $field => $table_name) {
            if (!empty($data[$field])) {
                $exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}{$table_name} WHERE id=%d AND campus_id=%d", $data[$field], $data['campus_id'] ?? 0));
                if (!$exists) self::redirect('error', __('One or more selected records are outside the active campus.', 'exam-system-pro'));
            }
        }
        if (in_array($entity, ['students', 'allocations'], true) && empty($data['session_id'])) {
            self::redirect('error', __('Select a valid active academic session first.', 'exam-system-pro'));
        }
        if ($entity === 'marks') {
            $schedule=$wpdb->get_row($wpdb->prepare("SELECT class_id FROM {$wpdb->prefix}esp_exam_schedules WHERE exam_id=%d AND campus_id=%d",$data['exam_id'],$data['campus_id']),ARRAY_A);
            if ($schedule) {
                $student_scope=$wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_students WHERE id=%d AND campus_id=%d AND class_id=%d",$data['student_id'],$data['campus_id'],$schedule['class_id']??0));
            } else {
                $student_scope = null;
            }
            $subject_scope=$wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_subjects WHERE id=%d AND campus_id=%d",$data['subject_id'],$data['campus_id']));
            if (!$schedule || !$student_scope || !$subject_scope) self::redirect('error', __('Exam schedule, student or subject relationship is invalid.', 'exam-system-pro'));
        }

        if ($entity === 'marks') {
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_marks WHERE exam_id = %d AND student_id = %d AND subject_id = %d",
                $data['exam_id'], $data['student_id'], $data['subject_id']
            ));
            $id = absint($existing);
        } elseif ($entity === 'exam_schedules' && empty($_POST['id'])) {
            $existing = $wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_exam_schedules WHERE exam_id=%d AND class_id=%d AND campus_id=%d",
                $data['exam_id'],
                $data['class_id'],
                $data['campus_id']
            ));
            $id = absint($existing);
        } else {
            $id = absint($_POST['id'] ?? 0);
        }

        $table = $wpdb->prefix . $definition['table'];
        $where = ['id' => $id];
        if (in_array($entity, ['classes', 'teachers', 'students', 'subjects', 'exams', 'exam_schedules', 'marks', 'allocations'], true)) {
            $where['campus_id'] = ESP_CampusContext::id();
        }
        $saved = $id ? $wpdb->update($table, $data, $where) !== false : $wpdb->insert($table, $data) !== false;
        self::redirect($saved ? 'updated' : 'error', $saved ? '' : $wpdb->last_error);
    }

    public static function delete(): void {
        self::authorize();
        global $wpdb;
        $entity = sanitize_key($_POST['entity'] ?? '');
        $definitions = self::definitions();
        if (!isset($definitions[$entity])) {
            wp_die(esc_html__('Invalid record type.', 'exam-system-pro'));
        }
        $where = ['id' => absint($_POST['id'] ?? 0)];
        if (in_array($entity, ['classes', 'teachers', 'students', 'subjects', 'exams', 'exam_schedules', 'marks', 'allocations'], true)) {
            $where['campus_id'] = ESP_CampusContext::id();
        }
        $wpdb->delete($wpdb->prefix . $definitions[$entity]['table'], $where);
        self::redirect('deleted');
    }

    public static function generate_results(): void {
        self::authorize();
        $exam_id = absint($_POST['exam_id'] ?? 0);
        $generated = $exam_id && (new ESP_ResultEngine())->generate($exam_id);
        if ($generated) {
            ESP_PositionEngine::calculate($exam_id);
        }
        self::redirect($generated ? 'updated' : 'error', $generated ? '' : __('Result generation failed.', 'exam-system-pro'));
    }

    public static function promote_student(): void {
        self::authorize();
        $service = new ESP_StudentPromotionService();
        $ok = $service->promote([absint($_POST['student_id'] ?? 0)], absint($_POST['new_session_id'] ?? 0), absint($_POST['new_class_id'] ?? 0)) > 0;
        self::redirect($ok ? 'updated' : 'error', $ok ? '' : __('Student, target class or target session is outside the active scope.', 'exam-system-pro'));
    }

    private static function authorize(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('You do not have permission to manage exam data.', 'exam-system-pro'));
        }
        check_admin_referer('esp_admin_record');
    }

    private static function redirect(string $status, string $message = ''): void {
        $base_url = wp_get_referer() ?: admin_url('admin.php?page=exam-system-pro');
        $base_url = remove_query_arg('edit_id', $base_url);
        $url = add_query_arg('esp_status', $status, $base_url);
        if ($message !== '') {
            $url = add_query_arg('esp_error', rawurlencode($message), $url);
        }
        wp_safe_redirect($url);
        exit;
    }

    public static function definitions(): array {
        return [
            'campuses' => ['table' => 'esp_campuses', 'fields' => ['name' => 'sanitize_text_field', 'code' => 'sanitize_text_field', 'address' => 'sanitize_textarea_field', 'phone' => 'sanitize_text_field', 'email' => 'sanitize_email', 'status' => 'int']],
            'sessions' => ['table' => 'esp_sessions', 'fields' => ['session_name' => 'sanitize_text_field', 'start_date' => 'sanitize_text_field', 'end_date' => 'sanitize_text_field', 'is_active' => 'int']],
            'classes' => ['table' => 'esp_classes', 'fields' => ['class_name' => 'sanitize_text_field', 'sort_order' => 'int']],
            'subjects' => ['table' => 'esp_subjects', 'fields' => ['subject_name' => 'sanitize_text_field', 'subject_code' => 'sanitize_text_field', 'total_marks' => 'floatval', 'passing_marks' => 'floatval']],
            'teachers' => ['table' => 'esp_teachers', 'fields' => ['teacher_name' => 'sanitize_text_field', 'employee_no' => 'sanitize_text_field', 'designation' => 'sanitize_text_field', 'mobile' => 'sanitize_text_field', 'email' => 'sanitize_email', 'status' => 'int']],
            'students' => ['table' => 'esp_students', 'fields' => ['roll_no' => 'sanitize_text_field', 'student_name' => 'sanitize_text_field', 'father_name' => 'sanitize_text_field', 'gender' => 'sanitize_text_field', 'class_id' => 'int', 'session_id' => 'int', 'mobile' => 'sanitize_text_field', 'address' => 'sanitize_textarea_field', 'status' => 'int']],
            'exams' => ['table' => 'esp_exams', 'fields' => ['exam_name' => 'sanitize_text_field', 'status' => 'int']],
            'exam_schedules' => ['table' => 'esp_exam_schedules', 'fields' => ['exam_id' => 'int', 'class_id' => 'int', 'exam_date' => 'sanitize_text_field', 'start_time' => 'sanitize_text_field', 'end_time' => 'sanitize_text_field', 'remarks' => 'sanitize_textarea_field', 'status' => 'int']],
            'marks' => ['table' => 'esp_marks', 'fields' => ['exam_id' => 'int', 'student_id' => 'int', 'subject_id' => 'int', 'obtained_marks' => 'floatval', 'remarks' => 'sanitize_textarea_field']],
            'allocations' => ['table' => 'esp_allocations', 'fields' => ['class_id' => 'int', 'subject_id' => 'int', 'teacher_id' => 'int', 'session_id' => 'int']],
        ];
    }
}
