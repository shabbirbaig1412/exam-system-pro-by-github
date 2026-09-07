<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin">
    <h1><?php esc_html_e('Campuses', 'exam-system-pro'); ?></h1>
    <?php ESP_AdminRecordForm::render('campuses', [
        'name' => __('Campus name', 'exam-system-pro'),
        'code' => __('Code', 'exam-system-pro'),
        'address' => __('Address', 'exam-system-pro'),
        'phone' => __('Phone', 'exam-system-pro'),
        'email' => __('Email', 'exam-system-pro'),
        'status' => __('Active (1=yes, 0=no)', 'exam-system-pro'),
    ]); ?>
    <div class="esp-saved-records">
    <?php ESP_AdminRecordForm::records_toolbar('campuses', __('Saved campuses', 'exam-system-pro')); ?>
    <table class="widefat striped esp-admin-table">
        <thead><tr><th><?php esc_html_e('Name', 'exam-system-pro'); ?></th><th><?php esc_html_e('Code', 'exam-system-pro'); ?></th><th><?php esc_html_e('Phone', 'exam-system-pro'); ?></th><th><?php esc_html_e('Status', 'exam-system-pro'); ?></th><th><?php esc_html_e('Actions', 'exam-system-pro'); ?></th></tr></thead>
        <tbody>
        <?php foreach ($campuses as $campus): ?>
            <tr>
                <td><?php echo esc_html($campus['name'] ?? ''); ?></td>
                <td><?php echo esc_html($campus['code'] ?? ''); ?></td>
                <td><?php echo esc_html($campus['phone'] ?? ''); ?></td>
                <td><?php echo !empty($campus['status']) ? esc_html__('Active', 'exam-system-pro') : esc_html__('Inactive', 'exam-system-pro'); ?></td>
                <td><a class="button button-small" href="<?php echo esc_url(add_query_arg('edit_id', absint($campus['id']), admin_url('admin.php?page=esp-campuses'))); ?>"><?php esc_html_e('Edit', 'exam-system-pro'); ?></a> <?php ESP_AdminRecordForm::delete_form('campuses', absint($campus['id'])); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</div>
