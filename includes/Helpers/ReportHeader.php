<?php

defined('ABSPATH') || exit;

class ESP_ReportHeader {

    public static function data(): array {

        return [

            'school' => ESP_SchoolHelper::name(),

            'campus' => CampusHelper::current()['name'] ?? '',

            'logo' => ESP_SchoolHelper::logo(),

            'principal' => ESP_SchoolHelper::principal(),

            'controller' => ESP_SchoolHelper::controller(),

        ];

    }

}
