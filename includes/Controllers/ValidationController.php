<?php

defined('ABSPATH') || exit;

class ESP_ValidationController {

    protected ESP_ValidationService $validator;

    public function __construct() {

        $this->validator =
            ESP_Container::make(
                ESP_ValidationService::class
            );

    }

    public function required(
        array $data,
        array $fields
    ): void {

        $this->validator->required(
            $data,
            $fields
        );

    }

}