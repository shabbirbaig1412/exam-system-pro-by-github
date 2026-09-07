<?php

defined('ABSPATH') || exit;

class ESP_GradeController {

    protected ESP_GradeService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_GradeService::class
            );

    }

    public function grade(
        float $percentage
    ): string {

        return $this->service->grade(
            $percentage
        );

    }

    public function remarks(
        float $percentage
    ): string {

        return $this->service->remarks(
            $percentage
        );

    }

}