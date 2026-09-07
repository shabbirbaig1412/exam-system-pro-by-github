<?php

defined('ABSPATH') || exit;

class ESP_InitHook {

    public static function register(): void {

        add_action(

            'init',

            [

                self::class,

                'boot'

            ]

        );

    }

    public static function boot(): void {

        (new ESP_Kernel())

            ->boot();

    }

}