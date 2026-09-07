<?php

defined('ABSPATH') || exit;

class ESP_Response {

    public static function success(

        string $message='',

        array $data=[]

    ): void {

        wp_send_json_success([

            'message'=>$message,

            'data'=>$data

        ]);

    }

    public static function error(

        string $message=''

    ): void {

        wp_send_json_error([

            'message'=>$message

        ]);

    }

}