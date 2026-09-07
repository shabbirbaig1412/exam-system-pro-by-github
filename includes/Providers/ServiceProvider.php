<?php

defined('ABSPATH') || exit;

class ESP_ServiceProvider {

    public static function register(): void {

        ESP_RepositoryServiceProvider::register();

    }

}