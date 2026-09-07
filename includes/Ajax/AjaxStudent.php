<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Student {

    public static function register(): void {

        add_action(
            'wp_ajax_esp_save_student',
            [self::class,'save']
        );

        add_action(
            'wp_ajax_esp_delete_student',
            [self::class,'delete']
        );

    }

    public static function save(): void {

        esp_verify_nonce();

        $service = ESP_Container::make(
            ESP_StudentService::class
        );

        wp_send_json_success(

            [

                'saved'=>$service->save($_POST)

            ]

        );

    }

    public static function delete(): void {

        esp_verify_nonce();

        $service = ESP_Container::make(
            ESP_StudentService::class
        );

        wp_send_json_success(

            [

                'deleted'=>$service->delete(

                    absint($_POST['id'])

                )

            ]

        );

    }

}