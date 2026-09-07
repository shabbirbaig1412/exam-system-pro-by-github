<?php

defined('ABSPATH') || exit;

class ESP_PositionEngine {

    public function assign(array &$results): array {

        usort($results, function ($a, $b) {

            if ((float) $a['percentage'] == (float) $b['percentage']) {
                return (int) ($a['student_id'] ?? 0) <=> (int) ($b['student_id'] ?? 0);
            }

            return ((float) $a['percentage'] > (float) $b['percentage']) ? -1 : 1;

        });

        $position = 0;
        $rank = 0;
        $previous = null;

        foreach ($results as &$row) {
            $position++;
            $score = (float) $row['percentage'];
            if ($previous === null || $score !== $previous) {
                $rank = $position;
                $previous = $score;
            }
            $row['position'] = $rank;

        }

        return $results;

    }

    public static function calculate(int $exam_id): void {
        global $wpdb;
        $campus = ESP_CampusContext::id();

        $results = $wpdb->get_results($wpdb->prepare(
            "SELECT r.id, r.percentage, r.obtained_marks
             FROM {$wpdb->prefix}esp_results r
             WHERE r.exam_id=%d
             AND r.campus_id=%d
             ORDER BY r.percentage DESC, r.obtained_marks DESC, r.id ASC",
            $exam_id,
            $campus
        ));

        $position = 0;
        $rank = 0;
        $previous = null;
        foreach ($results as $row) {
            $position++;
            $score = (float) $row->percentage;
            if ($previous === null || $score !== $previous) {
                $rank = $position;
                $previous = $score;
            }
            $wpdb->update($wpdb->prefix . 'esp_results', ['position' => $rank], ['id' => $row->id]);
        }
    }

}
