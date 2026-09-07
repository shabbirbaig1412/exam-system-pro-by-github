<?php

defined('ABSPATH') || exit;

class ESP_MarksObserver {

    public static function submitted(

        int $examId,

        int $teacherId

    ): void {

        ESP_Logger::log(

            'Marks submitted. Exam='.

            $examId.

            ', Teacher='.

            $teacherId

        );

    }

    public static function resubmitted(

        int $examId,

        int $teacherId

    ): void {

        ESP_Logger::log(

            'Marks resubmitted. Exam='.

            $examId.

            ', Teacher='.

            $teacherId

        );

    }

}