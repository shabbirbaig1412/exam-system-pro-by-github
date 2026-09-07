<?php

defined('ABSPATH') || exit;

function esp_percentage(

    float $obtained,

    float $total

): float {

    if (

        $total <= 0

    ) {

        return 0;

    }

    return round(

        ($obtained/$total)*100,

        2

    );

}

function esp_grade(

    float $percentage

): string {

    return ESP_GradeCalculator::grade(

        $percentage

    );

}