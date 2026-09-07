<?php

defined('ABSPATH') || exit;

class ESP_DashboardController {

    protected ESP_DashboardService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_DashboardService::class
            );

    }

    public function statistics(): array {

        return $this->service
            ->statistics();

    }

    public function charts(): array {

        return $this->service
            ->charts();

    }

    public function activities(): array {

        return $this->service
            ->recentActivities();

    }

    public function index(): void {

        ESP_View::render(

            'dashboard'

        );

    }

}