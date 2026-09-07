<?php

defined('ABSPATH') || exit;

class ESP_ReportCardPDF {

    public function generate(

        array $student

    ): void {

        ob_start();

        ESP_View::render(

            'pdf/report-card',

            [

                'student'=>$student

            ]

        );

        ESP_Container::make(

            ESP_PDFService::class

        )->download(

            ob_get_clean(),

            'ReportCard-'.$student['roll_no'].'.pdf'

        );

    }

}