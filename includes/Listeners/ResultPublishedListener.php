<?php

defined('ABSPATH') || exit;

class ESP_ResultPublishedListener {

    public static function register(): void {

        add_action(

            'esp_result_published',

            [

                self::class,

                'handle'

            ],

            10,

            1

        );

    }

    public static function handle(

        int $examId

    ): void {

        ESP_Logger::log(

            'Result published. Exam ID: '.$examId

        );

    }

}