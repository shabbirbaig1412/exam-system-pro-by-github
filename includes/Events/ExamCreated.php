<?php

defined('ABSPATH') || exit;

class ESP_ExamCreated {

    public static function dispatch(

        int $examId

    ): void {

        ESP_Event::dispatch(

            'exam_created',

            $examId

        );

    }

}