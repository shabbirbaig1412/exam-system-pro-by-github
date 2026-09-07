<?php

defined('ABSPATH') || exit;

class ESP_AssetsHook {

    public static function register(): void {

        ESP_AssetsLoader::register();

    }

}