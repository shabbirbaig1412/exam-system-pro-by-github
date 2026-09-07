<?php

defined('ABSPATH') || exit;

class ESP_Boot {

    public static function run(): void {

        ESP_ServiceProvider::register();

        ESP_Application::boot();

    }

}