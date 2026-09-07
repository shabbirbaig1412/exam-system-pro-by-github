<?php

defined('ABSPATH') || exit;

class ESP_ImportFactory {

    public static function csv(): ESP_ImportService {

        return new ESP_ImportService();

    }

}