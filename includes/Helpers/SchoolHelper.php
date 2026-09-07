<?php

defined('ABSPATH') || exit;

class ESP_SchoolHelper {

    public static function name(): string {

        return ESP_SchoolSettings::get()['school_name'];

    }

    public static function logo(): string {

        return ESP_SchoolSettings::get()['logo'];

    }

    public static function principal(): string {

        return ESP_SchoolSettings::get()['principal'];

    }

    public static function controller(): string {

        return ESP_SchoolSettings::get()['controller'];

    }

}