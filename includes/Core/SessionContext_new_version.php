<?php
defined('ABSPATH') || exit;

class ESP_SessionContext {
    private static int $session = 0;
    public static function set(int $id): void { self::$session = self::allowed($id) ? $id : 0; }
    public static function id(): int {
        if (self::$session && self::allowed(self::$session)) return self::$session;
        global $wpdb;
        self::$session = (int) get_user_meta(get_current_user_id(), 'esp_active_session_id', true);
        if (!self::allowed(self::$session)) {
            self::$session = (int) $wpdb->get_var("SELECT id FROM {$wpdb->prefix}esp_sessions WHERE is_active=1 ORDER BY id DESC LIMIT 1");
        }
        return self::$session;
    }
    public static function allowed(int $id): bool {
        global $wpdb;
        return $id > 0 && (bool) $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_sessions WHERE id=%d", $id));
    }
}
