<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Resubmit {

    public static function register(): void {

        add_action(

            'wp_ajax_esp_request_resubmit',

            [

                self::class,

                'request'

            ]

        );

    }

    public static function request(): void {

        esp_verify_nonce();

        $repo=ESP_Container::make(

            ESP_MarksRepository::class

        );

        $allowed=$repo->allowOneTimeResubmit(

            get_current_user_id(),

            absint($_POST['exam_id'])

        );

        if($allowed){

            wp_send_json_success([

                'message'=>'Resubmission enabled.'

            ]);

        }

        wp_send_json_error([

            'message'=>'Resubmission already used.'

        ]);

    }

}