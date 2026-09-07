<?php

defined('ABSPATH') || exit;

class ESP_AdminResultPage {

    public static function render(): void {
        ESP_Capability::admin();
        global $wpdb;
        $campus = ESP_CampusContext::id();
        
        $exams = (new ESP_ExamRepository())->all();
        $exam_id = absint($_GET['exam_id'] ?? 0);
        $results = $exam_id ? (new ESP_ResultRepository())->exam_results($exam_id) : [];
        
        // Get subjects allocated to classes for this exam's schedules
        $subjects = [];
        $subject_map = [];
        if ($exam_id) {
            $subjects = $wpdb->get_results($wpdb->prepare(
                "SELECT DISTINCT s.* FROM {$wpdb->prefix}esp_subjects s
                 INNER JOIN {$wpdb->prefix}esp_allocations a ON a.subject_id=s.id AND a.campus_id=s.campus_id
                 INNER JOIN {$wpdb->prefix}esp_exam_schedules es ON es.class_id=a.class_id AND es.exam_id=%d AND es.campus_id=s.campus_id
                 WHERE s.campus_id=%d
                 ORDER BY s.subject_name ASC",
                $exam_id,
                $campus
            ), ARRAY_A);
            
            // Build subject map for display
            $subject_map = array_map(function($s) {
                return ['id' => $s['id'], 'name' => $s['subject_name']];
            }, $subjects ?: []);
        }
        
        ESP_View::render('admin/results', compact('exams', 'exam_id', 'results', 'subjects', 'subject_map'));

    }

}
