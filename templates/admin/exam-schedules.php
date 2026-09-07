<?php defined('ABSPATH') || exit; ?>

<div class="wrap">

<h1 class="wp-heading-inline">

Exam Schedules

</h1>

<button
class="button button-primary"
id="esp-new-exam-schedule">

Create Exam Schedule

</button>

<hr>

<?php ESP_AdminRecordForm::render('exam_schedules', ['exam_id' => 'Exam', 'class_id' => 'Class', 'exam_date' => 'Exam date', 'start_time' => 'Start time', 'end_time' => 'End time', 'remarks' => 'Remarks']); ?>

<div class="esp-saved-records">
<?php ESP_AdminRecordForm::records_toolbar('exam_schedules', __('Saved schedules', 'exam-system-pro')); ?>
<?php 
$schedules = (new ESP_ExamScheduleRepository())->all();
foreach ($schedules as &$schedule) {
    $exam = (new ESP_ExamRepository())->find($schedule['exam_id']);
    $class = (new ESP_ClassRepository())->find($schedule['class_id']);
    $schedule['exam_name'] = $exam['exam_name'] ?? 'N/A';
    $schedule['class_name'] = $class['class_name'] ?? 'N/A';
}
?>
<?php ESP_AdminRecordForm::saved_table('exam_schedules', $schedules, ['exam_name' => __('Exam', 'exam-system-pro'), 'class_name' => __('Class', 'exam-system-pro'), 'exam_date' => __('Date', 'exam-system-pro'), 'status' => __('Status', 'exam-system-pro')]); ?>
</div>

</div>
