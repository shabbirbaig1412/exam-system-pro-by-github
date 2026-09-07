<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin">
    <h1><?php esc_html_e('Subject / Teacher Allocation', 'exam-system-pro'); ?></h1>
    <?php ESP_AdminRecordForm::render('allocations', [
        'class_id' => __('Class', 'exam-system-pro'),
        'subject_id' => __('Subject', 'exam-system-pro'),
        'teacher_id' => __('Teacher', 'exam-system-pro'),
    ]); ?>
    <div class="esp-saved-records">
    <?php ESP_AdminRecordForm::records_toolbar('allocations', __('Saved allocations', 'exam-system-pro')); ?>
    <table class="widefat striped esp-admin-table">
        <thead><tr><th><?php esc_html_e('Class', 'exam-system-pro'); ?></th><th><?php esc_html_e('Subject', 'exam-system-pro'); ?></th><th><?php esc_html_e('Teacher', 'exam-system-pro'); ?></th><th><?php esc_html_e('Actions', 'exam-system-pro'); ?></th></tr></thead>
        <tbody>
        <?php foreach ($allocations as $row): ?>
            <tr>
                <td><?php echo esc_html($row->class_name ?? ''); ?></td>
                <td><?php echo esc_html($row->subject_name ?? ''); ?></td>
                <td><?php echo esc_html($row->teacher_name ?? ''); ?></td>
                <td><a class="button button-small" href="<?php echo esc_url(add_query_arg('edit_id', absint($row->id), admin_url('admin.php?page=esp-allocations'))); ?>"><?php esc_html_e('Edit', 'exam-system-pro'); ?></a> <?php ESP_AdminRecordForm::delete_form('allocations', absint($row->id)); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table></div>
</div>
