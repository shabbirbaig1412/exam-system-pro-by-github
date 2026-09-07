<?php

defined('ABSPATH') || exit;

function esp_log(

    string $message

): void {

    ESP_Logger::log(

        $message

    );

}
