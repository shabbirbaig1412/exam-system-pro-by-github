<?php

defined('ABSPATH') || exit;

class ESP_SystemController {

    protected ESP_SystemService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_SystemService::class
            );

    }

    public function health(): array {

        return $this->service->health();

    }

    public function version(): string {

        return $this->service->version();

    }

}