<?php

defined('ABSPATH') || exit;

class ESP_LocalizationHook {

    public static function register(): void {

        add_action(

            'plugins_loaded',

            [

                self::class,

                'load'

            ]

        );

    }

    public static function load(): void {

        load_plugin_textdomain(

            'exam-system-pro',

            false,

            dirname(

                plugin_basename(

                    ESP_PLUGIN_FILE

                )

            )

            .

            '/languages'

        );

    }

}