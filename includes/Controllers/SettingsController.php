<?php

defined('ABSPATH') || exit;

class ESP_SettingsController {

    protected ESP_ConfigService $config;

    public function __construct() {

        $this->config =
            ESP_Container::make(
                ESP_ConfigService::class
            );

    }

    public function get(
        string $key,
        $default = null
    ) {

        return $this->config->get(
            $key,
            $default
        );

    }

    public function save(
        array $settings
    ): bool {

        foreach ($settings as $key => $value) {

            $this->config->set(
                $key,
                $value
            );

        }

        return true;

    }

}