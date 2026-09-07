<?php

defined('ABSPATH') || exit;

class ESP_StudentController {

    protected ESP_StudentService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_StudentService::class
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