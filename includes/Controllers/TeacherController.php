<?php

defined('ABSPATH') || exit;

class ESP_TeacherController {

    protected ESP_TeacherService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_TeacherService::class
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