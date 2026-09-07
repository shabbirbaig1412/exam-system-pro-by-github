<?php

defined('ABSPATH') || exit;

class ESP_MeritList {

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

        $repository = new ESP_ResultRepository();
        $results = $repository->exam_results($exam_id);

        usort($results, function($a, $b) {
            $posA = (int)($a->position ?? 0);
            $posB = (int)($b->position ?? 0);
            if ($posA === $posB) {
                return (float)($b->obtained_marks ?? 0) <=> (float)($a->obtained_marks ?? 0);
            }
            return $posA <=> $posB;
        });

        ESP_View::render('admin/merit-list', [
            'exam' => $exam,
            'exam_id' => $exam_id,
            'results' => $results,
        ]);
    }

}