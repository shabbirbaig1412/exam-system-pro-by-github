<?php

defined('ABSPATH') || exit;

class ESP_ResultObserver {

    public static function generated(

        int $examId

    ): void {

        ESP_Logger::log(

            'Results generated. Exam='.

            $examId

        );

    }

    public static function published(

        int $examId

    ): void {

        ESP_Logger::log(

            'Results published. Exam='.

            $examId

        );

    }

}