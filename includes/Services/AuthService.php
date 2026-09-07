<?php

defined('ABSPATH') || exit;

class ESP_AuthService {

    public function id(): int {

        return get_current_user_id();

    }

    public function user(): WP_User {

        return wp_get_current_user();

    }

    public function check(

        string $capability

    ): bool {

        return current_user_can(

            $capability

        );

    }

}