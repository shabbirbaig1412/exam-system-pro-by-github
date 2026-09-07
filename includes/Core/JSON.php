<?php

defined('ABSPATH') || exit;

class ESP_JSON {

    public static function success(

        array $data=[]

    ): void {

        wp_send_json_success(

            $data

        );

    }

    public static function error(

        string $message

    ): void {

        wp_send_json_error(

            [

                'message'=>$message

            ]

        );

    }

}