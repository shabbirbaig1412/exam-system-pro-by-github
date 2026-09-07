<?php

defined('ABSPATH') || exit;

class ESP_StudentCreated {

    public static function dispatch(

        int $studentId

    ): void {

        ESP_Event::dispatch(

            'student_created',

            $studentId

        );

    }

}