<?php

defined('ABSPATH') || exit;

class ESP_MarksSubmittedListener {

    public static function register(): void {

        add_action(

            'esp_marks_submitted',

            [

                self::class,

                'handle'

            ],

            10,

            2

        );

    }

    public static function handle(

        int $examId,

        int $teacherId

    ): void {

        ESP_Logger::log(

            'Marks submitted. Exam '.$examId.

            ', Teacher '.$teacherId

        );

    }

}