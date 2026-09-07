<?php

defined('ABSPATH') || exit;

class ESP_StudentCreatedListener {

    public static function register(): void {

        add_action(

            'esp_student_created',

            [

                self::class,

                'handle'

            ],

            10,

            1

        );

    }

    public static function handle(

        int $studentId

    ): void {

        ESP_Logger::log(

            'Student created ID: '.$studentId

        );

    }

}