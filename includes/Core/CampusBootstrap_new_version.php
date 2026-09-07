<?php
defined('ABSPATH') || exit;
class ESP_CampusBootstrap {
    public static function init(): void {
        if (isset($_GET['campus'])) {
            $campus = absint(wp_unslash($_GET['campus']));
            ESP_CampusContext::set($campus);
            if (ESP_CampusContext::allowed($campus) && is_user_logged_in()) update_user_meta(get_current_user_id(), 'esp_active_campus_id', $campus);
        }
        if (isset($_GET['session'])) {
            $session = absint(wp_unslash($_GET['session']));
            ESP_SessionContext::set($session);
            if (ESP_SessionContext::allowed($session) && is_user_logged_in()) update_user_meta(get_current_user_id(), 'esp_active_session_id', $session);
        }
    }
}
