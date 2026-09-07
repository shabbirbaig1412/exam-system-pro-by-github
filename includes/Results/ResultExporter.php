<?php

defined('ABSPATH') || exit;

class ESP_ResultExporter {

    public static function csv(

        array $rows,

        string $filename

    ): void {

        ESP_CSV::download(

            $rows,

            $filename

        );

    }

    public static function pdf(

        string $html,

        string $filename

    ): void {

        ESP_PDF::download(

            $html,

            $filename

        );

    }

}