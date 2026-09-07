<?php

defined('ABSPATH') || exit;

class ESP_ShortcodeHook {

    public static function register(): void {

        add_shortcode(

            'esp_dashboard',

            [

                self::class,

                'dashboard'

            ]

        );

    }

    public static function dashboard(): string {

        ob_start();

        ESP_View::render(

            'dashboard'

        );

        return ob_get_clean();

    }

}