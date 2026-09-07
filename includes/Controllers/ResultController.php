<?php

defined('ABSPATH') || exit;

class ESP_ResultController {

    protected ESP_ResultService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_ResultService::class
            );

    }

    public function index(): array {

        return $this->service->all();

    }

    public function publish(
        int $examId
    ): bool {

        return $this->service->publish(
            $examId
        );

    }

    public function delete(
        int $id
    ): bool {

        return $this->service->delete(
            $id
        );

    }

}