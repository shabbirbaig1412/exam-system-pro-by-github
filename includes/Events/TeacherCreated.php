<?php

defined('ABSPATH') || exit;

class ESP_TeacherCreated {

    public static function dispatch(

        int $teacherId

    ): void {

        ESP_Event::dispatch(

            'teacher_created',

            $teacherId

        );

    }

}