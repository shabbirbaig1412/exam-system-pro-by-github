<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Teacher {

    public static function register(): void {

        add_action(

            'wp_ajax_esp_save_teacher',

            [self::class,'save']

        );

        add_action(

            'wp_ajax_esp_delete_teacher',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        esp_verify_nonce();

        $service = ESP_Container::make(
            ESP_TeacherService::class
        );

        $saved = $service->save($_POST);

        wp_send_json_success(
            ['saved'=>$saved]
        );

    }

    public static function delete(): void {

        esp_verify_nonce();

        $service = ESP_Container::make(
            ESP_TeacherService::class
        );

        $deleted = $service->delete(
            absint($_POST['id'])
        );

        wp_send_json_success(
            ['deleted'=>$deleted]
        );

    }

}