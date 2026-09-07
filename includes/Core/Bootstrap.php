<?php

defined('ABSPATH') || exit;

class ESP_Bootstrap {

    public static function init(): void {

        ESP_Autoloader::register();

        ESP_Migration::run();

        ESP_Application::instance();

    }

}