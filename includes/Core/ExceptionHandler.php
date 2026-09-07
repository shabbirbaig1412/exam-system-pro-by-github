<?php

defined('ABSPATH') || exit;

class ESP_ExceptionHandler {

    public static function register(): void {

        set_exception_handler(

            [

                self::class,

                'handle'

            ]

        );

    }

    public static function handle(

        Throwable $e

    ): void {

        ESP_Logger::log(

            $e->getMessage()

        );

        wp_die(

            esc_html(

                $e->getMessage()

            )

        );

    }

}