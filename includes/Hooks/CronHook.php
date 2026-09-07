<?php

defined('ABSPATH') || exit;

class ESP_CronHook {

    public static function register(): void {

        add_action(

            'esp_daily_cleanup',

            [

                self::class,

                'cleanup'

            ]

        );

    }

    public static function cleanup(): void {

        ESP_Cache::forget(

            'esp_dashboard_statistics'

        );

    }

}