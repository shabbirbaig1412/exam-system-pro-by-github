<?php

defined('ABSPATH') || exit;

class ESP_Router {

    public static function register(): void {

        add_action(

            'admin_init',

            [self::class,'dispatch']

        );

    }

    public static function dispatch(): void {

        if (

            empty($_GET['page'])

        ) {

            return;

        }

        do_action(

            'esp_route_'.sanitize_key(

                $_GET['page']

            )

        );

    }

}