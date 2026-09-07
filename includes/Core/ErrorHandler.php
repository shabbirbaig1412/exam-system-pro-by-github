<?php

defined('ABSPATH') || exit;

class ESP_ErrorHandler {

    public static function register(): void {

        set_error_handler(

            [

                self::class,

                'handle'

            ]

        );

    }

    public static function handle(

        int $errno,

        string $errstr,

        string $errfile,

        int $errline

    ): bool {

        ESP_Logger::log(

            $errstr .

            ' (' .

            $errfile .

            ':' .

            $errline .

            ')'

        );

        return false;

    }

}