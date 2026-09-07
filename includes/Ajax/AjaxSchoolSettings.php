<?php

defined('ABSPATH') || exit;

class ESP_Ajax_SchoolSettings {

    public static function register(): void {

        add_action(

            'wp_ajax_esp_save_school_settings',

            [

                self::class,

                'save'

            ]

        );

    }

    public static function save(): void {

        esp_verify_nonce();

        update_option(

            ESP_SchoolSettings::OPTION,

            [

                'school_name'=>sanitize_text_field($_POST['school_name']),

                'school_code'=>sanitize_text_field($_POST['school_code']),

                'address'=>sanitize_textarea_field($_POST['address']),

                'phone'=>sanitize_text_field($_POST['phone']),

                'email'=>sanitize_email($_POST['email']),

                'website'=>esc_url_raw($_POST['website'])

            ]

        );

        wp_send_json_success();

    }

}