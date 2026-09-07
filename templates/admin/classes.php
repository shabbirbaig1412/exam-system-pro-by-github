<?php defined('ABSPATH') || exit; ?>

<div class="wrap">

<h1 class="wp-heading-inline">
    <?php esc_html_e('Classes','exam-system-pro'); ?>
</h1>

<button class="button button-primary esp-add-class">
    <?php esc_html_e('Add Class','exam-system-pro'); ?>
</button>

<hr>

<?php ESP_AdminRecordForm::render('classes', ['class_name' => 'Class name', 'sort_order' => 'Sort order']); ?>

<div class="esp-saved-records">
<?php ESP_AdminRecordForm::records_toolbar('classes', __('Saved classes', 'exam-system-pro')); ?>
<?php ESP_AdminRecordForm::saved_table('classes', (new ESP_ClassRepository())->all(), ['class_name' => __('Class', 'exam-system-pro'), 'sort_order' => __('Sort order', 'exam-system-pro')]); ?>
</div>

</div>
