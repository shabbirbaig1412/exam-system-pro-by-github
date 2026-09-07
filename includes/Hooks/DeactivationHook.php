<?php

defined('ABSPATH') || exit;

class ESP_DeactivationHook {

    public static function register(): void {

        register_deactivation_hook(

            ESP_PLUGIN_FILE,

            [

                self::class,

                'deactivate'

            ]

        );

    }

    public static function deactivate(): void {

        ESP_Registrar::deactivate();

    }

}