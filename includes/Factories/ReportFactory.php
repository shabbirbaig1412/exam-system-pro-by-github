<?php

defined('ABSPATH') || exit;

class ESP_ReportFactory {

    public static function make(

        string $report

    ): ESP_ReportInterface {

        return new $report();

    }

}