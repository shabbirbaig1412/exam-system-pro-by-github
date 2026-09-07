<?php

defined('ABSPATH') || exit;

class ESP_PluginLoadedHook {

    public static function register(): void {

        add_action(

            'plugins_loaded',

            [

                self::class,

                'loaded'

            ]

        );

    }

    public static function loaded(): void {

        do_action(

            'esp_loaded'

        );

    }

}