<?php

defined('ABSPATH') || exit;

class ESP_PDF {

    public static function download(array $rows, string $filename): void {

        ESP_CSV::download($rows, $filename);

    }

    public static function reportCard(

        array $data

    ): void {

        // Future TCPDF / Dompdf integration.

        do_action(

            'esp_generate_pdf',

            $data

        );

    }

}
