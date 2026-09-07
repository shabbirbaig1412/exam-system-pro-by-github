<?php

defined('ABSPATH') || exit;

class ESP_DashboardService {

    protected ESP_DashboardRepository $repository;

    public function __construct() {

        $this->repository =

            ESP_Container::make(

                ESP_DashboardRepository::class

            );

    }

    public function statistics(): array {

        return $this->repository->statistics();

    }

    public function charts(): array {

        return $this->repository->charts();

    }

    public function recentActivities(): array {

        return $this->repository->recentActivities();

    }

}