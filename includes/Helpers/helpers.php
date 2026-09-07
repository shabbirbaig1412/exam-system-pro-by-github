<?php

defined('ABSPATH') || exit;

if (!function_exists('esp_setting')) {

    function esp_setting(

        string $key,

        $default = null

    ) {

        return ESP_Config::get(

            $key,

            $default

        );

    }

}

if (!function_exists('esp_table')) {

    function esp_table(

        string $name

    ): string {

        return ESP_Database::table(

            $name

        );

    }

}

if (!function_exists('esp_now')) {

    function esp_now(): string {

        return current_time(

            'mysql'

        );

    }

}