<?php

defined('ABSPATH') || exit;

class ESP_ExportService {

    public function csv(

        array $rows,

        string $filename

    ): void {

        ESP_CSV::download(

            $rows,

            $filename

        );

    }

    public function excel(

        array $rows,

        string $filename

    ): void {

        ESP_Excel::export(

            $rows,

            $filename

        );

    }

    public function pdf(

        string $html,

        string $filename

    ): void {

        ESP_PDF::download(

            $html,

            $filename

        );

    }

}