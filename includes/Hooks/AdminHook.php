<?php

defined('ABSPATH') || exit;

class ESP_AdminHook {

    public static function register(): void {

        add_action(

            'admin_init',

            [

                self::class,

                'init'

            ]

        );

    }

    public static function init(): void {

        ESP_Flash::show();

    }

}
