<?php

defined('ABSPATH') || exit;

class ESP_AcademicSessionController {

    protected ESP_AcademicSessionService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_AcademicSessionService::class
            );

    }

    public function index(): array {

        return $this->service->all();

    }

    public function save(
        array $request
    ): bool {

        return $this->service->save($request);

    }

    public function delete(
        int $id
    ): bool {

        return $this->service->delete($id);

    }

}