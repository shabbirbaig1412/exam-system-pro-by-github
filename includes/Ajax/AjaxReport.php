<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Report {

    public static function register(): void {

        add_action(
            'wp_ajax_esp_report_gazette',
            [self::class,'gazette']
        );

    }

    public static function gazette(): void {

        esp_verify_nonce();

        $service=ESP_Container::make(
            ESP_ReportService::class
        );

        wp_send_json_success(

            $service->gazette(

                absint($_POST['exam_id'])

            )

        );

    }

}