<?php

defined('ABSPATH') || exit;

class ESP_SubjectObserver {

    public static function created(

        int $subjectId

    ): void {

        ESP_Logger::log(

            'Subject #'.$subjectId.

            ' created.'

        );

    }

    public static function updated(

        int $subjectId

    ): void {

        ESP_Logger::log(

            'Subject #'.$subjectId.

            ' updated.'

        );

    }

    public static function deleted(

        int $subjectId

    ): void {

        ESP_Logger::log(

            'Subject #'.$subjectId.

            ' deleted.'

        );

    }

}