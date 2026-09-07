<?php

defined('ABSPATH') || exit;

class ESP_SystemHealthObserver {

    public static function checked(): void {

        ESP_Logger::log(

            'System health checked.'

        );

    }

}