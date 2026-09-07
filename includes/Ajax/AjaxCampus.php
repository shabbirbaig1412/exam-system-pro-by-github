<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Campus {

    public static function register(): void{

        add_action(

            'wp_ajax_esp_save_campus',

            [

                self::class,

                'save'

            ]

        );

    }

    public static function save(): void{

        esp_verify_nonce();

        global $wpdb;

        $wpdb->insert(

            $wpdb->prefix.'esp_campuses',

            [

                'name'=>sanitize_text_field($_POST['name']),

                'code'=>sanitize_text_field($_POST['code']),

                'address'=>sanitize_textarea_field($_POST['address']),

                'phone'=>sanitize_text_field($_POST['phone']),

                'email'=>sanitize_email($_POST['email']),

                'status'=>1

            ]

        );

        wp_send_json_success();

    }

}