<?php

defined('ABSPATH') || exit;

class ESP_GradeCalculator {

    public static function grade(

        float $percentage

    ): string {

        return ESP_GradeEngine::grade($percentage);

    }

    public static function remarks(

        float $percentage

    ): string {

        return self::grade($percentage)=='F'

            ? 'Fail'

            : 'Pass';

    }

}
