<?php

defined('ABSPATH') || exit;

class ESP_ActivityController {

    protected ESP_ActivityLogService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_ActivityLogService::class
            );

    }

    public function log(
        string $action,
        string $description
    ): void {

        $this->service->log(
            $action,
            $description
        );

    }

}