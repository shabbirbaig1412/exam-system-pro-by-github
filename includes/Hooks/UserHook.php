<?php

defined('ABSPATH') || exit;

class ESP_UserHook {

    public static function register(): void {

        add_action(

            'user_register',

            [

                self::class,

                'created'

            ]

        );

    }

    public static function created(

        int $user_id

    ): void {

        ESP_Logger::log(

            'New WP User: '.$user_id

        );

    }

}