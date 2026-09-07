<?php

defined('ABSPATH') || exit;

class ESP_ClassObserver {

    public static function created(

        int $classId

    ): void {

        ESP_Logger::log(

            'Class #'.$classId.

            ' created.'

        );

    }

    public static function updated(

        int $classId

    ): void {

        ESP_Logger::log(

            'Class #'.$classId.

            ' updated.'

        );

    }

    public static function deleted(

        int $classId

    ): void {

        ESP_Logger::log(

            'Class #'.$classId.

            ' deleted.'

        );

    }

}