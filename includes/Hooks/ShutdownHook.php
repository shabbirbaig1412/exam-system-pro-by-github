<?php

defined('ABSPATH') || exit;

class ESP_ShutdownHook {

    public static function register(): void {

        add_action(

            'shutdown',

            [

                self::class,

                'run'

            ]

        );

    }

    public static function run(): void {

        if (

            function_exists(

                'session_write_close'

            )

        ) {

            @session_write_close();

        }

    }

}