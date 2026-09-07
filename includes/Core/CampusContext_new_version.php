<?php
defined('ABSPATH') || exit;

class ESP_CampusContext {
    private static int $campus = 0;

    public static function set(int $campusId): void {
        self::$campus = self::allowed($campusId) ? $campusId : 0;
    }

    public static function id(): int {
        if (self::$campus && self::allowed(self::$campus)) {
            return self::$campus;
        }
        $ids = self::allowed_ids();
        self::$campus = (int) get_user_meta(get_current_user_id(), 'esp_active_campus_id', true);
        if (!self::allowed(self::$campus)) {
            self::$campus = (int) get_user_meta(get_current_user_id(), 'esp_campus_id', true);
        }
        if (!in_array(self::$campus, $ids, true)) {
            self::$campus = (int) ($ids[0] ?? 0);
        }
        return self::$campus;
    }

    public static function allowed(int $id): bool {
        return $id > 0 && in_array($id, self::allowed_ids(), true);
    }

    public static function allowed_ids(): array {
        $ids = get_user_meta(get_current_user_id(), 'esp_campus_ids', true);
        if (!is_array($ids)) {
            $ids = [(int) get_user_meta(get_current_user_id(), 'esp_campus_id', true)];
        }
        $ids = array_values(array_filter(array_map('absint', $ids)));

        // If not explicitly set in user meta, check teacher profile table
        if (empty($ids) && is_user_logged_in()) {
            global $wpdb;
            $teacher_campuses = $wpdb->get_col($wpdb->prepare(
                "SELECT DISTINCT campus_id FROM {$wpdb->prefix}esp_teachers WHERE wp_user_id=%d AND status=1",
                get_current_user_id()
            ));
            if (!empty($teacher_campuses)) {
                $ids = array_values(array_filter(array_map('absint', (array)$teacher_campuses)));
            }
        }

        // An explicitly assigned administrator/user is always restricted,
        // even when the WordPress role has manage_options.
        if ($ids) {
            global $wpdb;
            $placeholders = implode(',', array_fill(0, count($ids), '%d'));
            return array_map('intval', (array) $wpdb->get_col($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_campuses WHERE status=1 AND id IN ({$placeholders}) ORDER BY name", ...$ids)));
        }
        if (current_user_can('manage_options')) {
            global $wpdb;
            return array_map('intval', (array) $wpdb->get_col("SELECT id FROM {$wpdb->prefix}esp_campuses WHERE status=1 ORDER BY name"));
        }
        return [];
    }

    public static function can_manage_registry(): bool {
        $assigned = get_user_meta(get_current_user_id(), 'esp_campus_ids', true);
        return current_user_can('manage_options') && empty($assigned);
    }
}
