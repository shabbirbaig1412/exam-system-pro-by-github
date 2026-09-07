<?php

defined('ABSPATH') || exit;

class ESP_ExcelExporter {

    public function classResult(

        int $exam_id

    ): void {

        $rows =

            (new ESP_ResultRepository())

            ->examResults(

                $exam_id

            );

        (new ESP_ExportService())

            ->csv(

                $rows,

                'class-result.csv'

            );

    }

}