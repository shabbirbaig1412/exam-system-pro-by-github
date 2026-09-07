<?php

defined('ABSPATH') || exit;

class ESP_ExceptionHandlerService {

    public static function report(

        Throwable $e

    ): void {

        ESP_Logger::log(

            sprintf(

                '[%s] %s in %s:%d',

                get_class($e),

                $e->getMessage(),

                $e->getFile(),

                $e->getLine()

            )

        );

    }

    public static function render(

        Throwable $e

    ): void {

        self::report($e);

        wp_die(

            esc_html(

                $e->getMessage()

            ),

            'Exam System Error',

            [

                'response' => 500

            ]

        );

    }

}