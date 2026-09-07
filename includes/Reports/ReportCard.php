<?php

defined('ABSPATH') || exit;

class ESP_ReportCard {

    public function render(int $exam_id, int $student_id = 0): void {
        global $wpdb;
        $campus = ESP_CampusContext::id();

        $exam = $wpdb->get_row($wpdb->prepare(
            "SELECT e.id, e.campus_id, e.exam_name, e.status, e.created_at, e.updated_at
             FROM {$wpdb->prefix}esp_exams e
             WHERE e.id=%d AND e.campus_id=%d",
            $exam_id,
            $campus
        ), ARRAY_A);

        // Fetch all students who have results/marks for this exam
        $students = (array) $wpdb->get_results($wpdb->prepare(
            "SELECT DISTINCT st.id, st.student_name, st.roll_no, st.father_name, st.gender
             FROM {$wpdb->prefix}esp_marks m
             INNER JOIN {$wpdb->prefix}esp_students st ON st.id=m.student_id AND st.campus_id=m.campus_id
             WHERE m.exam_id=%d AND m.campus_id=%d
             ORDER BY CAST(st.roll_no AS UNSIGNED) ASC, st.student_name ASC",
            $exam_id,
            $campus
        ));

        if (!$student_id && !empty($students)) {
            $student_id = (int)$students[0]->id;
        }

        $student = null;
        $subjects = [];
        $result_summary = null;

        if ($student_id) {
            $student = $wpdb->get_row($wpdb->prepare(
                "SELECT st.*, c.class_name
                 FROM {$wpdb->prefix}esp_students st
                 LEFT JOIN {$wpdb->prefix}esp_classes c ON c.id=st.class_id AND c.campus_id=st.campus_id
                 WHERE st.id=%d AND st.campus_id=%d",
                $student_id,
                $campus
            ));

            $subjects = (array) $wpdb->get_results($wpdb->prepare(
                "SELECT s.subject_name, s.subject_code, s.total_marks, s.passing_marks,
                        m.obtained_marks, m.remarks
                 FROM {$wpdb->prefix}esp_marks m
                 INNER JOIN {$wpdb->prefix}esp_subjects s ON s.id=m.subject_id AND s.campus_id=m.campus_id
                 WHERE m.exam_id=%d AND m.student_id=%d AND m.campus_id=%d
                 ORDER BY s.subject_name",
                $exam_id,
                $student_id,
                $campus
            ));

            $result_summary = $wpdb->get_row($wpdb->prepare(
                "SELECT * FROM {$wpdb->prefix}esp_results WHERE exam_id=%d AND student_id=%d AND campus_id=%d",
                $exam_id,
                $student_id,
                $campus
            ));
        }

        ESP_View::render('admin/report-card', [
            'exam' => $exam,
            'exam_id' => $exam_id,
            'students' => $students,
            'student_id' => $student_id,
            'student' => $student,
            'subjects' => $subjects,
            'result_summary' => $result_summary,
        ]);
    }

}
