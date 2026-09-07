<?php

defined('ABSPATH') || exit;

class ESP_GazettePDF {

    public function generate(

        array $students

    ): void {

        ob_start();

        ESP_View::render(

            'pdf/gazette',

            [

                'students'=>$students

            ]

        );

        ESP_Container::make(

            ESP_PDFService::class

        )->download(

            ob_get_clean(),

            'Gazette.pdf'

        );

    }

}