<?php

defined('ABSPATH') || exit;

function esp_user() {

    return wp_get_current_user();

}

function esp_user_id(): int {

    return get_current_user_id();

}

function esp_is_admin(): bool {

    return current_user_can(

        'manage_options'

    );

}

function esp_is_teacher(): bool {

    return current_user_can(

        'esp_teacher'

    );

}