<?php

defined('ABSPATH') || exit;

class ESP_StatisticsEngine {

    public function calculate(array $results): array {
        $stats = [
            'students' => count($results),
            'passed' => 0,
            'failed' => 0,
            'pass_percentage' => 0,
            'highest' => 0,
            'lowest' => 0,
            'average' => 0,
            'grades' => [],
        ];

        if (empty($results)) {
            return $stats;
        }

        $marks = [];

        foreach ($results as $row) {
            $status = is_array($row) ? ($row['status'] ?? '') : ($row->status ?? '');
            $obtained = is_array($row) ? ($row['obtained_marks'] ?? 0) : ($row->obtained_marks ?? 0);
            $grade = is_array($row) ? ($row['grade'] ?? '') : ($row->grade ?? '');
            $marks[] = (float) $obtained;

            if (strtoupper($status) === 'PASS') {
                $stats['passed']++;
            } else {
                $stats['failed']++;
            }

            if ($grade) {
                $stats['grades'][$grade] = ($stats['grades'][$grade] ?? 0) + 1;
            }
        }

        $stats['pass_percentage'] = $stats['students'] > 0 
            ? round(($stats['passed'] / $stats['students']) * 100, 2) 
            : 0;

        $stats['highest'] = max($marks);
        $stats['lowest'] = min($marks);
        $stats['average'] = round(array_sum($marks) / count($marks), 2);

        return $stats;
    }

    public static function classSummary(int $exam_id): array {

        global $wpdb;

        $rows = $wpdb->get_results($wpdb->prepare(
            "SELECT r.status
             FROM {$wpdb->prefix}esp_results r
             INNER JOIN {$wpdb->prefix}esp_exams e ON e.id=r.exam_id
             INNER JOIN {$wpdb->prefix}esp_students s ON s.id=r.student_id
             WHERE r.exam_id=%d
             AND s.campus_id=e.campus_id
             AND e.campus_id=%d",
            $exam_id,
            ESP_CampusContext::id()
        ));

        $summary = ['students' => 0, 'passed' => 0, 'failed' => 0];

        foreach ($rows as $row) {
            $summary['students']++;
            if (strtoupper($row->status) === 'PASS') {
                $summary['passed']++;
            } else {
                $summary['failed']++;
            }
        }

        return $summary;

    }

}
