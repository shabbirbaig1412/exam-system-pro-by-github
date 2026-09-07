<?php
defined('ABSPATH') || exit;
class ESP_AdminHeadHook {
    public static function register(): void { add_action('admin_notices', [self::class, 'render']); }
    public static function render(): void {
        if (!current_user_can('manage_options') && !current_user_can('esp_teacher')) return;
        
        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        $page = sanitize_key($_GET['page'] ?? '');
        $is_esp_page = strpos($page, 'esp-') === 0 || $page === 'exam-system-pro' || ($screen && strpos($screen->id, 'esp') !== false);
        
        if (!$is_esp_page && ($GLOBALS['pagenow'] ?? '') !== 'index.php') {
            return;
        }

        global $wpdb;
        $allowed = ESP_CampusContext::allowed_ids();
        if (!$allowed && !current_user_can('manage_options')) return;

        $campuses = (array) $wpdb->get_results("SELECT id, name FROM {$wpdb->prefix}esp_campuses WHERE status=1 ORDER BY name", ARRAY_A);
        if ($allowed) {
            $campuses = array_values(array_filter($campuses, static fn($row) => in_array((int)$row['id'], $allowed, true)));
        }
        $sessions = (array) $wpdb->get_results("SELECT id, session_name FROM {$wpdb->prefix}esp_sessions ORDER BY id DESC", ARRAY_A);

        if (!$campuses && !$sessions) return;

        $active_campus_id = ESP_CampusContext::id();
        $active_session_id = ESP_SessionContext::id();

        echo '<div class="notice notice-info esp-global-context-bar" style="display:flex;align-items:center;justify-content:space-between;padding:8px 14px;background:#fff;border-left:4px solid #2271b1;margin:15px 0 10px 0;box-shadow:0 1px 3px rgba(0,0,0,0.05);border-radius:4px;">';
        echo '<form method="get" class="esp-context-form" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin:0;">';
        
        // Preserve current GET parameters except campus, session, edit_id, esp_status, esp_error
        foreach ($_GET as $key => $value) {
            if (in_array($key, ['campus', 'session', 'edit_id', 'esp_status', 'esp_error'], true) || is_array($value)) continue;
            echo '<input type="hidden" name="' . esc_attr($key) . '" value="' . esc_attr(sanitize_text_field(wp_unslash($value))) . '">';
        }

        echo '<span style="font-weight:600;color:#1d2327;display:inline-flex;align-items:center;gap:6px;"><span class="dashicons dashicons-admin-site-alt3" style="color:#2271b1;"></span> ' . esc_html__('Active Context:', 'exam-system-pro') . '</span>';

        if ($campuses) {
            echo '<div style="display:inline-flex;align-items:center;gap:6px;">';
            echo '<label for="esp-campus-context" style="font-weight:500;color:#50575e;">' . esc_html__('Campus:', 'exam-system-pro') . '</label>';
            echo '<select id="esp-campus-context" name="campus" style="min-width:160px;font-weight:500;">';
            if (empty($active_campus_id)) {
                echo '<option value="">' . esc_html__('-- Select Campus --', 'exam-system-pro') . '</option>';
            }
            foreach ($campuses as $row) {
                echo '<option value="' . esc_attr($row['id']) . '" ' . selected($active_campus_id, (int)$row['id'], false) . '>' . esc_html($row['name']) . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }

        if ($sessions) {
            echo '<div style="display:inline-flex;align-items:center;gap:6px;">';
            echo '<label for="esp-session-context" style="font-weight:500;color:#50575e;">' . esc_html__('Session:', 'exam-system-pro') . '</label>';
            echo '<select id="esp-session-context" name="session" style="min-width:140px;font-weight:500;">';
            if (empty($active_session_id)) {
                echo '<option value="">' . esc_html__('-- Select Session --', 'exam-system-pro') . '</option>';
            }
            foreach ($sessions as $row) {
                echo '<option value="' . esc_attr($row['id']) . '" ' . selected($active_session_id, (int)$row['id'], false) . '>' . esc_html($row['session_name']) . '</option>';
            }
            echo '</select>';
            echo '</div>';
        }

        echo '<button class="button button-secondary" type="submit" style="margin-left:4px;">' . esc_html__('Switch', 'exam-system-pro') . '</button>';
        echo '</form>';
        echo '</div>';
    }
}
