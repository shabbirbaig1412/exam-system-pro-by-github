<?php

defined('ABSPATH') || exit;

class ESP_Excel {

    public static function import(

        string $file

    ): array {

        return

            (new ESP_ImportService())

            ->csv($file);

    }

    public static function export(

        array $rows,

        string $filename

    ): void {

        (new ESP_ExportService())

            ->csv(

                $rows,

                $filename

            );

    }

}