<?php

defined('ABSPATH') || exit;

class ESP_ProfileHook {

    public static function register(): void {

        add_action(

            'profile_update',

            [

                self::class,

                'updated'

            ],

            10,

            2

        );

    }

    public static function updated(

        int $user_id,

        WP_User $old_data

    ): void {

        ESP_Logger::log(

            'Profile updated. User ID: '.$user_id

        );

    }

}