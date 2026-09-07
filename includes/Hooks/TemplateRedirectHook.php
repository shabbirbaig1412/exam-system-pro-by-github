<?php

defined('ABSPATH') || exit;

class ESP_TemplateRedirectHook {

    public static function register(): void {

        add_action(

            'template_redirect',

            [

                self::class,

                'redirect'

            ]

        );

    }

    public static function redirect(): void {

        do_action(

            'esp_template_redirect'

        );

    }

}