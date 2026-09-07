<?php

defined('ABSPATH') || exit;

class ESP_TeacherObserver {

    public static function created(

        int $teacherId

    ): void {

        ESP_Logger::log(

            'Teacher #'.$teacherId.

            ' created.'

        );

    }

    public static function updated(

        int $teacherId

    ): void {

        ESP_Logger::log(

            'Teacher #'.$teacherId.

            ' updated.'

        );

    }

    public static function deleted(

        int $teacherId

    ): void {

        ESP_Logger::log(

            'Teacher #'.$teacherId.

            ' deleted.'

        );

    }

}