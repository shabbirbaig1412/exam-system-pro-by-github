<?php

defined('ABSPATH') || exit;

class ESP_GradeService {

    public function grade(
        float $percentage
    ): string {

        return ESP_GradeCalculator::grade(
            $percentage
        );

    }

    public function remarks(
        float $percentage
    ): string {

        return ESP_GradeCalculator::remarks(
            $percentage
        );

    }

}