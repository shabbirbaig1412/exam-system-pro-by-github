<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Result {

    public static function register(): void {

        add_action(
            'wp_ajax_esp_publish_result',
            [self::class,'publish']
        );

    }

    public static function publish(): void {

        esp_verify_nonce();
        if (!current_user_can('manage_options') && !current_user_can('esp_publish_results')) {
            wp_send_json_error(['message' => 'Not authorized.'], 403);
        }

        $service=ESP_Container::make(
            ESP_ResultService::class
        );

        wp_send_json_success(

            [

                'published'=>$service->publish(

                    absint($_POST['exam_id'] ?? 0)

                )

            ]

        );

    }

}
