<?php

defined('ABSPATH') || exit;

class ESP_SubjectSummary {

    public function render(int $exam_id): void {
        global $wpdb;
        $campus = ESP_CampusContext::id();

        $exam = $wpdb->get_row($wpdb->prepare(
            "SELECT e.id, e.campus_id, e.exam_name, e.status, e.created_at, e.updated_at
             FROM {$wpdb->prefix}esp_exams e
             WHERE e.id=%d AND e.campus_id=%d",
            $exam_id,
            $campus
        ), ARRAY_A);

        $subjects = (array) $wpdb->get_results(
            $wpdb->prepare(
                "SELECT
                    s.id AS subject_id,
                    s.subject_name,
                    s.subject_code,
                    s.total_marks,
                    s.passing_marks,
                    COUNT(m.id) AS students,
                    AVG(m.obtained_marks) AS average,
                    MAX(m.obtained_marks) AS highest,
                    MIN(m.obtained_marks) AS lowest
                FROM {$wpdb->prefix}esp_subjects s
                INNER JOIN {$wpdb->prefix}esp_marks m ON m.subject_id=s.id AND m.campus_id=s.campus_id
                WHERE m.exam_id=%d
                AND m.campus_id=%d
                GROUP BY s.id
                ORDER BY s.subject_name",
                $exam_id,
                $campus
            )
        );

        ESP_View::render('admin/subject-summary', [
            'exam' => $exam,
            'exam_id' => $exam_id,
            'subjects' => $subjects,
        ]);
    }

}
