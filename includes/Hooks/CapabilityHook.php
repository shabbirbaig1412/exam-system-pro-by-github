<?php

defined('ABSPATH') || exit;

class ESP_CapabilityHook {

    public static function register(): void {

        add_action(

            'init',

            [

                self::class,

                'load'

            ]

        );

    }

    public static function load(): void {

        ESP_PermissionService::install();

    }

}