<?php

defined('ABSPATH') || exit;

class ESP_ActivationHook {

    public static function register(): void {

        register_activation_hook(

            ESP_PLUGIN_FILE,

            [

                self::class,

                'activate'

            ]

        );

    }

    public static function activate(): void {

        // Activation must not send output because WordPress reports any
        // buffered content as unexpected plugin output.
        ob_start();

        try {

            ESP_Registrar::activate();

        } finally {

            ob_end_clean();

        }

    }

}
