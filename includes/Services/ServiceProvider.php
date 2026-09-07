<?php

defined('ABSPATH') || exit;

class ESP_ServiceRegistry {

    public static function register(): void {

        ESP_Container::singleton(

            ESP_AuthService::class,

            fn()=>new ESP_AuthService()

        );

        ESP_Container::singleton(

            ESP_CacheService::class,

            fn()=>new ESP_CacheService()

        );

        ESP_Container::singleton(

            ESP_ConfigService::class,

            fn()=>new ESP_ConfigService()

        );

        ESP_Container::singleton(

            ESP_ValidationService::class,

            fn()=>new ESP_ValidationService()

        );

    }

}