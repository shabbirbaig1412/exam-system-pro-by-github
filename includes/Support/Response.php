<?php

defined('ABSPATH') || exit;

class ESP_SupportResponse {

    public static function json(

        array $data,

        int $status=200

    ): void {

        status_header(

            $status

        );

        wp_send_json(

            $data

        );

    }

}