<?php

defined('ABSPATH') || exit;

class ESP_ExportResults {

    public function download(int $exam_id): void {

        $repository = new ESP_ResultRepository();

        $rows = $repository->exam_results($exam_id);

        (new ESP_ExcelEngine())->export(

            'exam-results.csv',

            $rows

        );

    }

}