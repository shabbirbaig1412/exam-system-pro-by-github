<?php

defined('ABSPATH') || exit;

class ESP_Notice {

    public static function success(string $message): void {

        echo '<div class="notice notice-success"><p>'

            .esc_html($message).

            '</p></div>';

    }

    public static function error(string $message): void {

        echo '<div class="notice notice-error"><p>'

            .esc_html($message).

            '</p></div>';

    }

}