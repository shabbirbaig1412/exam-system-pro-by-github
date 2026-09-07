<?php

defined('ABSPATH') || exit;

class ESP_ObserverServiceProvider {

    public static function register(): void {

        ESP_SystemObserver::register();

    }

}