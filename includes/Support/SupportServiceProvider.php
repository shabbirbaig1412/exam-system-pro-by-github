<?php

defined('ABSPATH') || exit;

class ESP_SupportServiceProvider {

    public static function register(): void {

        ESP_Container::singleton(

            ESP_SupportCollection::class,

            fn()=>new ESP_SupportCollection()

        );

    }

}