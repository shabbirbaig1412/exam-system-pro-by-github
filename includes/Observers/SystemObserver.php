<?php

defined('ABSPATH') || exit;

class ESP_SystemObserver {

    public static function register(): void {

        add_action(

            'esp_loaded',

            [

                self::class,

                'loaded'

            ]

        );

    }

    public static function loaded(): void {

        ESP_Logger::log(

            'Exam System initialized.'

        );

    }

}