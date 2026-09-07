<?php

defined('ABSPATH') || exit;

class ESP_ExamObserver {

    public static function created(

        int $examId

    ): void {

        ESP_Logger::log(

            'Exam #'.$examId.

            ' created.'

        );

    }

    public static function published(

        int $examId

    ): void {

        ESP_Logger::log(

            'Exam #'.$examId.

            ' published.'

        );

    }

}