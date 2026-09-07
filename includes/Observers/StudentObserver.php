<?php

defined('ABSPATH') || exit;

class ESP_StudentObserver {

    public static function created(

        int $studentId

    ): void {

        ESP_Logger::log(

            'Student #'.$studentId.

            ' created.'

        );

    }

    public static function promoted(

        int $studentId

    ): void {

        ESP_Logger::log(

            'Student #'.$studentId.

            ' promoted.'

        );

    }

    public static function deleted(

        int $studentId

    ): void {

        ESP_Logger::log(

            'Student #'.$studentId.

            ' deleted.'

        );

    }

}