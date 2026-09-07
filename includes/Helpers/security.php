<?php

defined('ABSPATH') || exit;

function esp_is_teacher(): bool {
    if (!is_user_logged_in()) {
        return false;
    }
    if (current_user_can('manage_options') || current_user_can('esp_teacher') || current_user_can('esp_enter_marks')) {
        return true;
    }
    global $wpdb;
    return (bool) $wpdb->get_var($wpdb->prepare(
        "SELECT id FROM {$wpdb->prefix}esp_teachers WHERE wp_user_id=%d AND status=1 LIMIT 1",
        get_current_user_id()
    ));
}

function esp_verify_nonce(string $action = 'esp_nonce'): void {
    if (!is_user_logged_in()) {
        if (wp_doing_ajax()) {
            wp_send_json_error(['message' => esc_html__('You must be logged in.', 'exam-system-pro')], 401);
        }
        wp_die(esc_html__('You must be logged in.', 'exam-system-pro'), '', ['response' => 401]);
    }

    $nonce = sanitize_text_field(wp_unslash($_REQUEST['_wpnonce'] ?? $_REQUEST['nonce'] ?? ''));
    if (!wp_verify_nonce($nonce, $action)) {
        if (wp_doing_ajax()) {
            wp_send_json_error(['message' => esc_html__('Security check failed. Please refresh the page.', 'exam-system-pro')], 403);
        }
        wp_die(esc_html__('Security check failed.', 'exam-system-pro'), '', ['response' => 403]);
    }

    if (!esp_can_manage() && !esp_is_teacher()) {
        if (wp_doing_ajax()) {
            wp_send_json_error(['message' => esc_html__('You do not have permission to perform this action.', 'exam-system-pro')], 403);
        }
        wp_die(esc_html__('You do not have permission to perform this action.', 'exam-system-pro'), '', ['response' => 403]);
    }
}

function esp_can_manage(): bool {
    return current_user_can('manage_options');
}


