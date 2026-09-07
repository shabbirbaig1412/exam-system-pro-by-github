<?php defined('ABSPATH') || exit; ?>

<div class="wrap">

<h1 class="wp-heading-inline">

Teachers

</h1>

<button
class="button button-primary"
id="esp-new-teacher">

Add Teacher

</button>

<hr>

<?php ESP_AdminRecordForm::render('teachers', ['teacher_name' => 'Teacher name', 'employee_no' => 'Employee number', 'designation' => 'Designation', 'mobile' => 'Mobile', 'email' => 'Email', 'status' => 'Active (1=yes, 0=no)']); ?>

<div class="esp-saved-records">
<?php ESP_AdminRecordForm::records_toolbar('teachers', __('Saved teachers', 'exam-system-pro')); ?>
<?php ESP_AdminRecordForm::saved_table('teachers', (new ESP_TeacherRepository())->all(), ['teacher_name' => __('Teacher', 'exam-system-pro'), 'email' => __('Email', 'exam-system-pro'), 'mobile' => __('Phone', 'exam-system-pro'), 'status' => __('Status', 'exam-system-pro')]); ?>
</div>

</div>
