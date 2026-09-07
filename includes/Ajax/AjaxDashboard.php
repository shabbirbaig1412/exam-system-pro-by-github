<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Dashboard {

    public static function register(): void {

        add_action(
            'wp_ajax_esp_dashboard_stats',
            [self::class,'stats']
        );

    }

    public static function stats(): void {

        esp_verify_nonce();

        $service=ESP_Container::make(
            ESP_DashboardService::class
        );

        wp_send_json_success(

            $service->statistics()

        );

    }

}