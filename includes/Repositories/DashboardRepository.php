<?php

defined('ABSPATH') || exit;

class ESP_DashboardRepository {

    public function statistics(): array {
        global $wpdb;
        $campus = ESP_CampusContext::id();
        $count = static function (string $table) use ($wpdb, $campus): int {
            return (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}esp_{$table} WHERE campus_id=%d",
                $campus
            ));
        };
        return [
            'students' => $count('students'),
            'teachers' => $count('teachers'),
            'classes' => $count('classes'),
            'subjects' => $count('subjects'),
            'exams' => $count('exams'),
            'results' => $count('results'),
            'session' => (string) $wpdb->get_var("SELECT session_name FROM {$wpdb->prefix}esp_sessions WHERE is_active=1 ORDER BY id DESC LIMIT 1"),
        ];
    }

    public function charts(): array {
        return [];
    }

    public function recentActivities(): array {
        return [];
    }
}
