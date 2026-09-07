<?php

defined('ABSPATH') || exit;

class ESP_DeleteUserHook {

    public static function register(): void {

        add_action(

            'delete_user',

            [

                self::class,

                'deleted'

            ]

        );

    }

    public static function deleted(

        int $user_id

    ): void {

        ESP_Logger::log(

            'Deleted WP User: '.$user_id

        );

    }

}