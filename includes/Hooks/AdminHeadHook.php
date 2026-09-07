<?php

defined('ABSPATH') || exit;

class ESP_AdminHeadHook {

    public static function register(): void {

        add_action(

            'admin_head',

            [

                self::class,

                'render'

            ]

        );

    }

    public static function render(): void {

        do_action(

            'esp_admin_head'

        );

    }

}