<?php

defined('ABSPATH') || exit;

class ESP_InitSessionHook {

    public static function register(): void {

        add_action(

            'init',

            [

                self::class,

                'start'

            ],

            1

        );

    }

    public static function start(): void {

        if (

            session_status()

            ===

            PHP_SESSION_NONE

        ) {

            @session_start();

        }

    }

}