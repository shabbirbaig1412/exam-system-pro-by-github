<?php

defined('ABSPATH') || exit;

class ESP_LoginHook {

    public static function register(): void {

        add_action(

            'wp_login',

            [

                self::class,

                'login'

            ],

            10,

            2

        );

    }

    public static function login(

        string $user_login,

        WP_User $user

    ): void {

        ESP_Logger::log(

            'User login: '.$user_login

        );

    }

}