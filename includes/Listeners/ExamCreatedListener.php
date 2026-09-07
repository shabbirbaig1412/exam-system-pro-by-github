<?php

defined('ABSPATH') || exit;

class ESP_ExamCreatedListener {

    public static function register(): void {

        add_action(

            'esp_exam_created',

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

            'Exam created ID: '.$examId

        );

    }

}