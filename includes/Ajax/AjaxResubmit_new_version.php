<?php
defined('ABSPATH') || exit;
class ESP_Ajax_Resubmit {

    public static function register(): void {
        add_action('wp_ajax_esp_request_resubmit', [self::class, 'request']);
        add_action('wp_ajax_esp_grant_resubmit', [self::class, 'grant']);
    }

    public static function request(): void {
        esp_verify_nonce();

        global $wpdb;
        $campus = ESP_CampusContext::id();
        $exam_id = absint($_POST['exam_id'] ?? 0);
        $class_id = absint($_POST['class_id'] ?? 0);
        $subject_id = absint($_POST['subject_id'] ?? 0);

        if (!$campus || !$exam_id || !$subject_id) {
            wp_send_json_error(['message' => esc_html__('Missing parameters for resubmission request.', 'exam-system-pro')], 400);
        }

        $teacher_id = (int)$wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_teachers WHERE wp_user_id=%d AND campus_id=%d AND status=1",
            get_current_user_id(),
            $campus
        ));

        if (!current_user_can('manage_options') && !$teacher_id) {
            wp_send_json_error(['message' => esc_html__('Only allocated teachers can request resubmission.', 'exam-system-pro')], 403);
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
            wp_send_json_error(['message' => esc_html__('Exam not found.', 'exam-system-pro')], 404);
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

        // Log request or record notification
        if (class_exists('ESP_LogRepository')) {
            (new ESP_LogRepository())->log(
                'info',
                sprintf('Teacher #%d requested marks resubmission for Exam #%d, Class #%d, Subject #%d', $teacher_id, $exam_id, $class_id, $subject_id),
                get_current_user_id(),
                $campus
            );
        }

        wp_send_json_success([
            'message' => esc_html__('Resubmission request recorded. Please notify your administrator to unlock this sheet.', 'exam-system-pro')
        ]);
    }

    public static function grant(): void {
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => esc_html__('Administrator capability required.', 'exam-system-pro')], 403);
        }
        esp_verify_nonce();

        global $wpdb;
        $campus = ESP_CampusContext::id();
        $exam_id = absint($_POST['exam_id'] ?? 0);
        $teacher_id = absint($_POST['teacher_id'] ?? 0);
        $subject_id = absint($_POST['subject_id'] ?? 0);
        $class_id = absint($_POST['class_id'] ?? 0);

        if (!$class_id) {
            wp_send_json_error(['message' => esc_html__('Please select a class.', 'exam-system-pro')], 400);
        }

        $exam_row = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_exams WHERE id=%d AND campus_id=%d",
            $exam_id,
            $campus
        ));

        if (!$exam_row) {
            wp_send_json_error(['message' => esc_html__('Invalid exam.', 'exam-system-pro')], 400);
        }

        $schedule = $wpdb->get_row($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_exam_schedules WHERE exam_id=%d AND class_id=%d AND campus_id=%d",
            $exam_id,
            $class_id,
            $campus
        ));

        if (!$schedule) {
            wp_send_json_error(['message' => esc_html__('Invalid exam schedule.', 'exam-system-pro')], 400);
        }

        $session = ESP_SessionContext::id();

        $teacher_ok = (bool)$wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_teachers WHERE id=%d AND campus_id=%d AND status=1",
            $teacher_id,
            $campus
        ));

        $subject_ok = (bool)$wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_subjects WHERE id=%d AND campus_id=%d",
            $subject_id,
            $campus
        ));

        $allocation = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$wpdb->prefix}esp_allocations 
             WHERE campus_id=%d AND session_id=%d AND class_id=%d AND subject_id=%d AND teacher_id=%d",
            $campus,
            $session,
            $class_id,
            $subject_id,
            $teacher_id
        ));

        if (!$teacher_ok || !$subject_ok || !$allocation) {
            wp_send_json_error(['message' => esc_html__('Invalid resubmission allocation scope.', 'exam-system-pro')], 400);
        }

        // Delete any existing unused grants to grant a fresh one
        $wpdb->delete(
            $wpdb->prefix . 'esp_mark_resubmits',
            [
                'campus_id' => $campus,
                'session_id' => $session,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'subject_id' => $subject_id,
                'teacher_id' => $teacher_id,
                'used_at' => null,
            ]
        );

        $ok = $wpdb->insert(
            $wpdb->prefix . 'esp_mark_resubmits',
            [
                'campus_id' => $campus,
                'session_id' => $session,
                'exam_id' => $exam_id,
                'class_id' => $class_id,
                'subject_id' => $subject_id,
                'teacher_id' => $teacher_id,
                'granted_by' => get_current_user_id(),
                'created_at' => current_time('mysql'),
            ]
        );

        if ($ok) {
            wp_send_json_success(['message' => esc_html__('One-time resubmission granted successfully.', 'exam-system-pro')]);
        } else {
            wp_send_json_error(['message' => esc_html__('Could not grant resubmission.', 'exam-system-pro')], 500);
        }
    }
}
