<?php

defined('ABSPATH') || exit;

class ESP_SubjectController {

    protected ESP_SubjectService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_SubjectService::class
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