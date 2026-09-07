<?php defined('ABSPATH') || exit; ?>

<div class="wrap">

<h1 class="wp-heading-inline">

Examinations

</h1>

<button
class="button button-primary"
id="esp-new-exam">

Create Exam

</button>

<hr>

<?php ESP_AdminRecordForm::render('exams', ['exam_name' => 'Exam name']); ?>

<div class="esp-saved-records">
<?php ESP_AdminRecordForm::records_toolbar('exams', __('Saved exams', 'exam-system-pro')); ?>
<?php ESP_AdminRecordForm::saved_table('exams', (new ESP_ExamRepository())->all(), ['exam_name' => __('Exam', 'exam-system-pro'), 'status' => __('Status', 'exam-system-pro')]); ?>
</div>

</div>
