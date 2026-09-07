<?php

defined('ABSPATH') || exit;

class ESP_AuthController {

    protected ESP_AuthService $auth;

    public function __construct() {

        $this->auth =
            ESP_Container::make(
                ESP_AuthService::class
            );

    }

    public function user(): WP_User {

        return $this->auth->user();

    }

    public function id(): int {

        return $this->auth->id();

    }

    public function can(
        string $capability
    ): bool {

        return $this->auth->check(
            $capability
        );

    }

}