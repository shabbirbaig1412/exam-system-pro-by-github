<?php

defined('ABSPATH') || exit;

class ESP_ReportCardPrinter {

    public function print(

        int $exam_id,

        int $student_id

    ): void {

        $data =

            ESP_ReportEngine::reportCard(

                $exam_id,

                $student_id

            );

        extract($data);

        require

        ESP_TEMPLATE

        .'print/report-card.php';

    }

}