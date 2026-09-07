<?php

defined('ABSPATH') || exit;

class ESP_ServiceFactory {

    public static function make(

        string $service

    ) {

        return ESP_Container::make(

            $service

        );

    }

}