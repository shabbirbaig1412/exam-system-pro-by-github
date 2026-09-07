<?php

defined('ABSPATH') || exit;

class ESP_StudentDashboard {

    public function profile(

        int $studentId

    ): array {

        return [

            'student'=>[],

            'results'=>[],

            'attendance'=>[],

            'fee'=>[]

        ];

    }

}