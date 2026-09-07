<?php

defined('ABSPATH') || exit;

function esp_success(

    string $message,

    array $data=[]

): void {

    ESP_Response::success(

        $message,

        $data

    );

}

function esp_error(

    string $message

): void {

    ESP_Response::error(

        $message

    );

}