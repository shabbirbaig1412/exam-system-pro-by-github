<?php

defined('ABSPATH') || exit;

class ESP_TeacherCreatedListener {

    public static function register(): void {

        add_action(

            'esp_teacher_created',

            [

                self::class,

                'handle'

            ],

            10,

            1

        );

    }

    public static function handle(

        int $teacherId

    ): void {

        ESP_Logger::log(

            'Teacher created ID: '.$teacherId

        );

    }

}