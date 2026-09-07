<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin">
    <h1><?php esc_html_e('Academic Sessions', 'exam-system-pro'); ?></h1>
    <?php ESP_AdminRecordForm::render('sessions', [
        'session_name' => __('Session name', 'exam-system-pro'),
        'start_date' => __('Start date', 'exam-system-pro'),
        'end_date' => __('End date', 'exam-system-pro'),
        'is_active' => __('Active (1=yes, 0=no)', 'exam-system-pro'),
    ]); ?>
    <div class="esp-saved-records">
    <?php ESP_AdminRecordForm::records_toolbar('sessions', __('Saved sessions', 'exam-system-pro')); ?>
    <table class="widefat striped esp-admin-table">
        <thead><tr><th><?php esc_html_e('Session', 'exam-system-pro'); ?></th><th><?php esc_html_e('Start', 'exam-system-pro'); ?></th><th><?php esc_html_e('End', 'exam-system-pro'); ?></th><th><?php esc_html_e('Status', 'exam-system-pro'); ?></th><th><?php esc_html_e('Actions', 'exam-system-pro'); ?></th></tr></thead>
        <tbody>
        <?php foreach ($sessions as $session): ?>
            <tr>
                <td><?php echo esc_html($session['session_name'] ?? ''); ?></td>
                <td><?php echo esc_html($session['start_date'] ?? ''); ?></td>
                <td><?php echo esc_html($session['end_date'] ?? ''); ?></td>
                <td><?php echo !empty($session['is_active']) ? esc_html__('Active', 'exam-system-pro') : esc_html__('Inactive', 'exam-system-pro'); ?></td>
                <td><a class="button button-small" href="<?php echo esc_url(add_query_arg('edit_id', absint($session['id']), admin_url('admin.php?page=esp-sessions'))); ?>"><?php esc_html_e('Edit', 'exam-system-pro'); ?></a> <?php ESP_AdminRecordForm::delete_form('sessions', absint($session['id'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</div>
