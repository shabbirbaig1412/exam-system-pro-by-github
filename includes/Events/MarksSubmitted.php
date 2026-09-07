<?php

defined('ABSPATH') || exit;

class ESP_MarksSubmitted {

    public static function dispatch(

        int $examId,

        int $teacherId

    ): void {

        ESP_Event::dispatch(

            'marks_submitted',

            $examId,

            $teacherId

        );

    }

}