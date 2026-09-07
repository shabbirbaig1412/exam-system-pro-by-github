<?php

defined('ABSPATH') || exit;

class ESP_NotificationController {

    protected ESP_NotificationService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_NotificationService::class
            );

    }

    public function success(
        string $message
    ): void {

        $this->service->success(
            $message
        );

    }

    public function error(
        string $message
    ): void {

        $this->service->error(
            $message
        );

    }

    public function info(
        string $message
    ): void {

        $this->service->info(
            $message
        );

    }

}