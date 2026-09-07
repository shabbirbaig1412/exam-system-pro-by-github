<?php

defined('ABSPATH') || exit;

class ESP_ExportSummary {

    public function download(int $exam_id): void {

        $rows = (new ESP_ResultRepository())

            ->exam_results($exam_id);

        (new ESP_ExcelEngine())->export(

            'summary.csv',

            $rows

        );

    }

}