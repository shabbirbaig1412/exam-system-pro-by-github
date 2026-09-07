<?php

defined('ABSPATH') || exit;

class ESP_UpgradeHook {

    public static function register(): void {

        add_action(

            'plugins_loaded',

            [

                self::class,

                'upgrade'

            ]

        );

    }

    public static function upgrade(): void {

        if (

            get_option(

                'esp_db_version'

            )

            !==

            ESP_DB_VERSION

        ) {

            ESP_Migration::run();

        }

    }

}
