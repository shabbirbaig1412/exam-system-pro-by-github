<?php

defined('ABSPATH') || exit;

class ESP_CampusHelper {

    public static function current(): array {

        return ESP_Container::make(

            ESP_CampusRepository::class

        )->find(

            ESP_CampusContext::id()

        );

    }

}