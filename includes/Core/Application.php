<?php

defined('ABSPATH') || exit;

class ESP_Application {

    public static function boot(): void {

        ESP_ExceptionHandler::register();

        ESP_ErrorHandler::register();

        ESP_AssetsLoader::register();

        ESP_Ajax::register();

    }

}
