<?php

defined('ABSPATH') || exit;

class ESP_AdminMarksPage {

    public static function render(): void {
        ESP_Capability::teacher();
        global $wpdb;
        $campus = ESP_CampusContext::id();
        $session = ESP_SessionContext::id();

        $is_admin = current_user_can('manage_options');
        $teacher_id = 0;

        if (!$is_admin) {
            $teacher_id = (int)$wpdb->get_var($wpdb->prepare(
                "SELECT id FROM {$wpdb->prefix}esp_teachers WHERE wp_user_id=%d AND campus_id=%d AND status=1",
                get_current_user_id(),
                $campus
            ));
        }

        if ($is_admin) {
            $exams = (array)$wpdb->get_results($wpdb->prepare(
                "SELECT e.*
                 FROM {$wpdb->prefix}esp_exams e
                 WHERE e.campus_id=%d AND e.status=1
                 ORDER BY e.exam_name ASC",
                $campus
            ), ARRAY_A);

            // Load exam schedules with class info
            $schedules = (array)$wpdb->get_results($wpdb->prepare(
                "SELECT es.*, c.class_name 
                 FROM {$wpdb->prefix}esp_exam_schedules es 
                 LEFT JOIN {$wpdb->prefix}esp_classes c ON c.id=es.class_id AND c.campus_id=es.campus_id
                 WHERE es.campus_id=%d AND es.status=1 
                 ORDER BY es.exam_date DESC",
                $campus
            ), ARRAY_A);

            $classes = (array)$wpdb->get_results($wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}esp_classes WHERE campus_id=%d AND status=1 ORDER BY sort_order, class_name",
                $campus
            ), ARRAY_A);

            $subjects = (array)$wpdb->get_results($wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}esp_subjects WHERE campus_id=%d AND status=1 ORDER BY subject_name",
                $campus
            ), ARRAY_A);

            // Fetch allocations for dependent filtering
            $allocations = (array)$wpdb->get_results($wpdb->prepare(
                "SELECT DISTINCT class_id, subject_id FROM {$wpdb->prefix}esp_allocations WHERE campus_id=%d AND session_id=%d",
                $campus,
                $session
            ), ARRAY_A);
        } else {
            if (!$teacher_id) {
                $exams = [];
                $schedules = [];
                $classes = [];
                $subjects = [];
                $allocations = [];
            } else {
                    $exams = (array)$wpdb->get_results($wpdb->prepare(
                        "SELECT DISTINCT e.*
                     FROM {$wpdb->prefix}esp_exams e 
                     INNER JOIN {$wpdb->prefix}esp_exam_schedules es ON es.exam_id=e.id AND es.campus_id=e.campus_id AND es.status=1
                     INNER JOIN {$wpdb->prefix}esp_allocations a ON a.campus_id=e.campus_id AND a.session_id=%d AND a.class_id=es.class_id 
                     WHERE e.campus_id=%d AND e.status=1 AND a.teacher_id=%d 
                     ORDER BY e.exam_name ASC",
                    $session,
                    $campus,
                    $teacher_id
                    ), ARRAY_A);

                $schedules = (array)$wpdb->get_results($wpdb->prepare(
                    "SELECT es.*, c.class_name 
                     FROM {$wpdb->prefix}esp_exam_schedules es 
                     INNER JOIN {$wpdb->prefix}esp_allocations a ON a.campus_id=es.campus_id AND a.session_id=%d AND a.class_id=es.class_id 
                     LEFT JOIN {$wpdb->prefix}esp_classes c ON c.id=es.class_id AND c.campus_id=es.campus_id
                     WHERE es.campus_id=%d AND es.status=1 AND a.teacher_id=%d 
                     ORDER BY es.exam_date DESC",
                    $session,
                    $campus,
                    $teacher_id
                ), ARRAY_A);

                $classes = (array)$wpdb->get_results($wpdb->prepare(
                    "SELECT DISTINCT c.* 
                     FROM {$wpdb->prefix}esp_classes c 
                     INNER JOIN {$wpdb->prefix}esp_allocations a ON a.class_id=c.id AND a.campus_id=c.campus_id 
                     WHERE a.campus_id=%d AND a.session_id=%d AND a.teacher_id=%d AND c.status=1 
                     ORDER BY c.sort_order, c.class_name",
                    $campus,
                    $session,
                    $teacher_id
                ), ARRAY_A);

                $subjects = (array)$wpdb->get_results($wpdb->prepare(
                    "SELECT DISTINCT s.* 
                     FROM {$wpdb->prefix}esp_subjects s 
                     INNER JOIN {$wpdb->prefix}esp_allocations a ON a.subject_id=s.id AND a.campus_id=s.campus_id 
                     WHERE a.campus_id=%d AND a.session_id=%d AND a.teacher_id=%d AND s.status=1 
                     ORDER BY s.subject_name",
                    $campus,
                    $session,
                    $teacher_id
                ), ARRAY_A);

                $allocations = (array)$wpdb->get_results($wpdb->prepare(
                    "SELECT class_id, subject_id FROM {$wpdb->prefix}esp_allocations WHERE campus_id=%d AND session_id=%d AND teacher_id=%d",
                    $campus,
                    $session,
                    $teacher_id
                ), ARRAY_A);
            }
        }

        // Build class-to-subjects map
        $class_subject_map = [];
        foreach ($allocations as $alloc) {
            $c_id = (int)$alloc['class_id'];
            $s_id = (int)$alloc['subject_id'];
            if (!isset($class_subject_map[$c_id])) {
                $class_subject_map[$c_id] = [];
            }
            if (!in_array($s_id, $class_subject_map[$c_id], true)) {
                $class_subject_map[$c_id][] = $s_id;
            }
        }

        ESP_View::render('admin/marks', [
            'exams' => $exams,
            'schedules' => $schedules,
            'classes' => $classes,
            'subjects' => $subjects,
            'class_subject_map' => $class_subject_map,
            'is_admin' => $is_admin,
            'teacher_id' => $teacher_id,
            'has_teacher_profile' => $is_admin || ($teacher_id > 0),
        ]);
    }
}
