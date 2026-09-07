<?php

defined('ABSPATH') || exit;

class ESP_TabulationPDF {

    public function generate(

        array $rows

    ): void {

        ob_start();

        ESP_View::render(

            'pdf/tabulation',

            [

                'rows'=>$rows

            ]

        );

        ESP_Container::make(

            ESP_PDFService::class

        )->download(

            ob_get_clean(),

            'Tabulation.pdf'

        );

    }

}