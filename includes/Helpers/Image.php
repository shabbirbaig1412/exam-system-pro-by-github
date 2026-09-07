<?php

defined('ABSPATH') || exit;

class ESP_Image {

    public static function url(int $attachmentId): string {

        return wp_get_attachment_url($attachmentId) ?: '';

    }

    public static function logo(): string {

        return ESP_URL

            .'assets/images/logo.png';

    }

}
