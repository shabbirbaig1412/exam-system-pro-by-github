<?php

defined('ABSPATH') || exit;

class ESP_LogoutHook {

    public static function register(): void {

        add_action(

            'wp_logout',

            [

                self::class,

                'logout'

            ]

        );

    }

    public static function logout(): void {

        ESP_Logger::log(

            'User logout.'

        );

    }

}