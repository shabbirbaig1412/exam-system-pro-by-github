<?php

defined('ABSPATH') || exit;

class ESP_AdminReportPage {

    public static function render(): void {
        ESP_Capability::admin();

        $report = sanitize_key($_GET['report'] ?? '');
        $exam_id = absint($_GET['exam_id'] ?? 0);
        $student_id = absint($_GET['student_id'] ?? 0);

        if ($report && $exam_id) {
            switch ($report) {
                case 'class-summary':
                    (new ESP_ClassSummary())->render($exam_id);
                    return;
                case 'all-classes-summary':
                    (new ESP_AllClassesSummary())->render($exam_id);
                    return;
                case 'merit-list':
                    (new ESP_MeritList())->render($exam_id);
                    return;
                case 'report-card':
                    (new ESP_ReportCard())->render($exam_id, $student_id);
                    return;
                case 'statistics':
                    (new ESP_StatisticsReport())->render($exam_id);
                    return;
                case 'subject-summary':
                    (new ESP_SubjectSummary())->render($exam_id);
                    return;
                case 'teacher-summary':
                    (new ESP_TeacherSummary())->render($exam_id);
                    return;
                case 'class-result':
                    (new ESP_ClassResult())->render($exam_id);
                    return;
                case 'failed-students':
                    (new ESP_FailedStudents())->render($exam_id);
                    return;
            }
        }

        $exams = (new ESP_ExamRepository())->all();
        ESP_View::render('admin/reports', ['exams' => $exams]);
    }

}
