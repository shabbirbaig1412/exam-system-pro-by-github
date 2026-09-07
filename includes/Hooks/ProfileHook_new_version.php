<?php
defined('ABSPATH') || exit;
class ESP_ProfileHook {
    public static function register(): void {
        add_action('show_user_profile', [self::class, 'fields']);
        add_action('edit_user_profile', [self::class, 'fields']);
        add_action('user_new_form', [self::class, 'fields']);
        add_action('personal_options_update', [self::class, 'save']);
        add_action('edit_user_profile_update', [self::class, 'save']);
        add_action('user_register', [self::class, 'save']);
    }
    public static function fields($user): void {
        if (!ESP_CampusContext::can_manage_registry()) return;
        global $wpdb;
        $campuses = (array) $wpdb->get_results("SELECT id,name FROM {$wpdb->prefix}esp_campuses WHERE status=1 ORDER BY name", ARRAY_A);
        $selected = is_object($user) ? (array) get_user_meta($user->ID, 'esp_campus_ids', true) : [];
        $selected = array_map('absint', $selected);
        wp_nonce_field('esp_user_campus_access', 'esp_user_campus_nonce');
        echo '<h2>' . esc_html__('Exam System Campus Access', 'exam-system-pro') . '</h2><table class="form-table"><tr><th><label>' . esc_html__('Allowed campuses', 'exam-system-pro') . '</label></th><td><p class="description">' . esc_html__('Select one or more campuses. The user will not be able to view or edit other campus data.', 'exam-system-pro') . '</p>';
        foreach ($campuses as $campus) echo '<label style="display:block"><input type="checkbox" name="esp_campus_ids[]" value="' . esc_attr($campus['id']) . '" ' . checked(in_array((int)$campus['id'], $selected, true), true, false) . '> ' . esc_html($campus['name']) . '</label>';
        echo '</td></tr></table>';
    }
    public static function save(int $user_id): void {
        if (!ESP_CampusContext::can_manage_registry() || !current_user_can('edit_user', $user_id)) return;
        if (empty($_POST['esp_user_campus_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['esp_user_campus_nonce'])), 'esp_user_campus_access')) return;
        global $wpdb; $ids = array_values(array_filter(array_map('absint', (array)($_POST['esp_campus_ids'] ?? []))));
        if ($ids) {
            $placeholders = implode(',', array_fill(0, count($ids), '%d'));
            $valid = $wpdb->get_col($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_campuses WHERE status=1 AND id IN ({$placeholders})", ...$ids));
            $ids = array_values(array_intersect($ids, array_map('intval', $valid ?: [])));
        }
        update_user_meta($user_id, 'esp_campus_ids', $ids);
        update_user_meta($user_id, 'esp_campus_id', (int)($ids[0] ?? 0));
    }
}
