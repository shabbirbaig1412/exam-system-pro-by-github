<?php defined('ABSPATH') || exit; ?>

<div class="wrap">

<h1 class="wp-heading-inline">

Subjects

</h1>

<a href="#"

class="button button-primary">

New Subject

</a>

<hr>

<?php ESP_AdminRecordForm::render('subjects', ['subject_name' => 'Subject name', 'subject_code' => 'Subject code', 'total_marks' => 'Total marks', 'passing_marks' => 'Passing marks']); ?>

<div class="esp-saved-records">
<?php ESP_AdminRecordForm::records_toolbar('subjects', __('Saved subjects', 'exam-system-pro')); ?>
<?php ESP_AdminRecordForm::saved_table('subjects', (new ESP_SubjectRepository())->all(), ['subject_name' => __('Subject', 'exam-system-pro'), 'subject_code' => __('Code', 'exam-system-pro'), 'total_marks' => __('Total marks', 'exam-system-pro'), 'passing_marks' => __('Passing marks', 'exam-system-pro')]); ?>
</div>

</div>
