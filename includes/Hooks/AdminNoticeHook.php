<?php

defined('ABSPATH') || exit;

class ESP_AdminNoticeHook {

    public static function register(): void {

        add_action(

            'admin_notices',

            [

                self::class,

                'show'

            ]

        );

    }

    public static function show(): void {

        ESP_Flash::show();

    }

}