<?php

defined('ABSPATH') || exit;

class ESP_AllClassesSummary {

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

        // Calculate class-wise aggregates
        $classes_data = $wpdb->get_results($wpdb->prepare(
            "SELECT c.class_name, 
                    COUNT(r.id) as total_appeared,
                    SUM(CASE WHEN r.status = 'PASS' THEN 1 ELSE 0 END) as passed,
                    SUM(CASE WHEN r.status = 'FAIL' THEN 1 ELSE 0 END) as failed,
                    AVG(r.percentage) as avg_percentage
             FROM {$wpdb->prefix}esp_results r
             INNER JOIN {$wpdb->prefix}esp_students s ON s.id = r.student_id
             INNER JOIN {$wpdb->prefix}esp_classes c ON c.id = s.class_id
             WHERE r.exam_id = %d AND r.campus_id = %d
             GROUP BY c.id
             ORDER BY c.sort_order ASC, c.class_name ASC",
            $exam_id, $campus
        ));
        
        // Let's get total students per class for 'absents'
        // Absents = total students in class - total_appeared
        $total_students_map = [];
        $total_students_data = $wpdb->get_results($wpdb->prepare(
            "SELECT c.class_name, COUNT(s.id) as total_students
             FROM {$wpdb->prefix}esp_students s
             INNER JOIN {$wpdb->prefix}esp_classes c ON c.id = s.class_id
             WHERE s.campus_id = %d AND s.status = 1
             GROUP BY c.id",
            $campus
        ));
        
        foreach ($total_students_data as $ts) {
            $total_students_map[$ts->class_name] = (int)$ts->total_students;
        }
        
        foreach ($classes_data as $row) {
            $total_enrolled = $total_students_map[$row->class_name] ?? (int)$row->total_appeared;
            $row->absents = max(0, $total_enrolled - (int)$row->total_appeared);
            
            $appeared = (int)$row->total_appeared;
            $passed = (int)$row->passed;
            $row->pass_pct = $appeared > 0 ? round(($passed / $appeared) * 100, 2) : 0;
            
            // Calculate average grade manually based on avg percentage or fetch it.
            $avg_pct = (float)$row->avg_percentage;
            if (method_exists('ESP_PositionEngine', 'determine_grade')) {
                $row->average_grade = ESP_PositionEngine::determine_grade($avg_pct);
            } else {
                $row->average_grade = $avg_pct >= 80 ? 'A+' : ($avg_pct >= 70 ? 'A' : ($avg_pct >= 60 ? 'B' : ($avg_pct >= 50 ? 'C' : ($avg_pct >= 40 ? 'D' : 'F'))));
            }
        }

        ESP_View::render('admin/all-classes-summary', [
            'exam' => $exam,
            'exam_id' => $exam_id,
            'classes_data' => $classes_data,
        ]);
    }

}
