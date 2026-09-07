<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin">
    <h1><?php esc_html_e('School Settings', 'exam-system-pro'); ?></h1>
    <?php if (sanitize_key($_GET['esp_status'] ?? '') === 'updated'): ?><div class="notice notice-success is-dismissible"><p><?php esc_html_e('Settings saved successfully.', 'exam-system-pro'); ?></p></div><?php endif; ?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="esp-card">
        <input type="hidden" name="action" value="esp_save_record">
        <input type="hidden" name="entity" value="settings">
        <?php wp_nonce_field('esp_admin_record'); ?>
        <table class="form-table">
            <?php foreach ([
                'school_name' => __('School name', 'exam-system-pro'),
                'school_code' => __('School code', 'exam-system-pro'),
                'address' => __('Address', 'exam-system-pro'),
                'phone' => __('Phone', 'exam-system-pro'),
                'email' => __('Email', 'exam-system-pro'),
                'website' => __('Website', 'exam-system-pro'),
            ] as $key => $label): ?>
                <tr><th><label for="esp-setting-<?php echo esc_attr($key); ?>"><?php echo esc_html($label); ?></label></th><td>
                <?php if ($key === 'address'): ?><textarea class="large-text" rows="3" id="esp-setting-<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>"><?php echo esc_textarea($settings[$key] ?? ''); ?></textarea>
                <?php else: ?><input class="regular-text" type="<?php echo $key === 'email' ? 'email' : ($key === 'website' ? 'url' : 'text'); ?>" id="esp-setting-<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($settings[$key] ?? ''); ?>"><?php endif; ?>
                </td></tr>
            <?php endforeach; ?>
        </table>
        <?php submit_button(__('Save settings', 'exam-system-pro')); ?>
    </form>
</div>
