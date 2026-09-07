<?php

defined('ABSPATH') || exit;

class ESP_TeacherSummary {

    public function generate(int $teacher_id): array {

        global $wpdb;

        return $wpdb->get_results($wpdb->prepare(
            "SELECT c.class_name, s.subject_name, COUNT(DISTINCT m.student_id) students, AVG(m.obtained_marks) average_marks
             FROM {$wpdb->prefix}esp_allocations a
             INNER JOIN {$wpdb->prefix}esp_classes c ON c.id=a.class_id
             INNER JOIN {$wpdb->prefix}esp_subjects s ON s.id=a.subject_id
             LEFT JOIN {$wpdb->prefix}esp_exam_schedules es ON es.class_id=a.class_id AND es.campus_id=a.campus_id
             LEFT JOIN {$wpdb->prefix}esp_marks m ON m.subject_id=a.subject_id AND m.exam_id=es.exam_id AND m.campus_id=a.campus_id
             WHERE a.teacher_id=%d AND a.campus_id=%d AND a.session_id=%d GROUP BY a.class_id, a.subject_id",
            $teacher_id
            , ESP_CampusContext::id()
            , ESP_SessionContext::id()
        ));

    }

    public function render(int $exam_id): void {
        global $wpdb;
        $campus = ESP_CampusContext::id();
        $session = ESP_SessionContext::id();

        $exam = $wpdb->get_row($wpdb->prepare(
            "SELECT e.id, e.campus_id, e.exam_name, e.status, e.created_at, e.updated_at
             FROM {$wpdb->prefix}esp_exams e
             WHERE e.id=%d AND e.campus_id=%d",
            $exam_id,
            $campus
        ), ARRAY_A);

        // Fetch all teachers and their allocations, joined with marks for this exam
        // We need: Teacher, Class, Subject, Total Students (appeared), Pass%, Highest, Lowest, Average Grade
        $sql = "
            SELECT 
                t.id as teacher_id,
                t.teacher_name,
                c.class_name,
                s.subject_name,
                s.total_marks as max_subject_marks,
                s.passing_marks,
                COUNT(m.id) as total_appeared,
                MAX(m.obtained_marks) as highest_marks,
                MIN(m.obtained_marks) as lowest_marks,
                AVG(m.obtained_marks) as average_marks,
                SUM(CASE WHEN m.obtained_marks >= COALESCE(s.passing_marks, 40) THEN 1 ELSE 0 END) as passed_students
            FROM {$wpdb->prefix}esp_teachers t
            INNER JOIN {$wpdb->prefix}esp_allocations a ON a.teacher_id = t.id AND a.session_id = %d
            INNER JOIN {$wpdb->prefix}esp_classes c ON c.id = a.class_id
            INNER JOIN {$wpdb->prefix}esp_subjects s ON s.id = a.subject_id
            LEFT JOIN {$wpdb->prefix}esp_marks m ON m.subject_id = a.subject_id AND m.exam_id = %d AND m.student_id IN (
                SELECT id FROM {$wpdb->prefix}esp_students WHERE class_id = a.class_id
            )
            WHERE t.campus_id = %d AND t.status = 1
            GROUP BY t.id, a.class_id, a.subject_id
            ORDER BY t.teacher_name, c.sort_order, s.subject_name
        ";
        
        $teacher_data = $wpdb->get_results($wpdb->prepare($sql, $session, $exam_id, $campus));

        foreach ($teacher_data as $row) {
            $appeared = (int)$row->total_appeared;
            $passed = (int)$row->passed_students;
            $row->pass_pct = $appeared > 0 ? round(($passed / $appeared) * 100, 2) : 0;
            
            // Average grade based on percentage
            $max = (float)$row->max_subject_marks;
            $avg_obtained = (float)$row->average_marks;
            $avg_pct = $max > 0 ? ($avg_obtained / $max) * 100 : 0;
            
            if (method_exists('ESP_PositionEngine', 'determine_grade')) {
                $row->average_grade = ESP_PositionEngine::determine_grade($avg_pct);
            } else {
                $row->average_grade = $avg_pct >= 80 ? 'A+' : ($avg_pct >= 70 ? 'A' : ($avg_pct >= 60 ? 'B' : ($avg_pct >= 50 ? 'C' : ($avg_pct >= 40 ? 'D' : 'F'))));
            }
        }

        ESP_View::render('admin/teacher-summary', [
            'exam' => $exam,
            'exam_id' => $exam_id,
            'teacher_data' => $teacher_data,
        ]);
    }
}
