<?php

defined('ABSPATH') || exit;

class ESP_PromotionController {

    protected ESP_PromotionService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_PromotionService::class
            );

    }

    public function promote(
        int $studentId,
        int $classId
    ): bool {

        return $this->service->promote(
            $studentId,
            $classId
        );

    }

}