<?php

defined('ABSPATH') || exit;

class ESP_SystemService {

    public function version(): string {

        return ESP_VERSION;

    }

    public function databaseVersion(): string {

        return get_option(

            'esp_db_version',

            ''

        );

    }

    public function health(): array {

        return [

            'php'        => PHP_VERSION,

            'wordpress'  => get_bloginfo('version'),

            'plugin'     => ESP_VERSION,

            'db_version' => $this->databaseVersion(),

        ];

    }

}