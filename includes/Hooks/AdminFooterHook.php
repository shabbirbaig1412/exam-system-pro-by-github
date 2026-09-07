<?php

defined('ABSPATH') || exit;

class ESP_AdminFooterHook {

    public static function register(): void {

        add_action(

            'admin_footer',

            [

                self::class,

                'render'

            ]

        );

    }

    public static function render(): void {

        do_action(

            'esp_admin_footer'

        );

    }

}
