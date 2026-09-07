<?php

defined('ABSPATH') || exit;

class ESP_MeritListGenerator {

    public function generate(array|int $students, int $limit = 10): array {

        if (is_array($students)) {
            return ESP_PositionCalculator::calculate($students);
        }

        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT r.*, s.student_name, s.roll_no FROM {$wpdb->prefix}esp_results r
             INNER JOIN {$wpdb->prefix}esp_exams e ON e.id=r.exam_id
             INNER JOIN {$wpdb->prefix}esp_students s ON s.id=r.student_id
             WHERE r.exam_id=%d
             AND s.campus_id=e.campus_id
             AND e.campus_id=%d
             ORDER BY r.position ASC, r.student_id ASC LIMIT %d",
             $students,
            ESP_CampusContext::id(),
            $limit
        ));

    }

}
