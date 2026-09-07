<?php

defined('ABSPATH') || exit;

class ESP_SettingsObserver {

    public static function updated(): void {

        ESP_Logger::log(

            'Plugin settings updated.'

        );

        ESP_Cache::forget(

            'esp_settings'

        );

    }

}