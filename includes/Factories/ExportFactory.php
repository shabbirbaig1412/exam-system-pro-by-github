<?php

defined('ABSPATH') || exit;

class ESP_ExportFactory {

    public static function csv(): ESP_ExportService {

        return new ESP_ExportService();

    }

    public static function excel(): ESP_Excel {

        return new ESP_Excel();

    }

    public static function pdf(): ESP_PDF {

        return new ESP_PDF();

    }

}