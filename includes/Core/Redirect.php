<?php

defined('ABSPATH') || exit;

class ESP_Redirect {

    public static function back(): void {

        wp_safe_redirect(

            wp_get_referer()

        );

        exit;

    }

    public static function to(

        string $url

    ): void {

        wp_safe_redirect(

            $url

        );

        exit;

    }

}