<?php

defined('ABSPATH') || exit;

class ESP_ImportController {

    protected ESP_ImportService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_ImportService::class
            );

    }

    public function students(
        string $file
    ): bool {

        return $this->service
            ->students(
                $file
            );

    }

    public function marks(
        string $file
    ): bool {

        return $this->service
            ->marks(
                $file
            );

    }

}