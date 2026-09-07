<?php

defined('ABSPATH') || exit;

class ESP_Version {

    public static function current(): string {

        return self::plugin();

    }

    public static function plugin(): string {

        return

            ESP_VERSION;

    }

    public static function database(): string {

        return

            ESP_DB_VERSION;

    }

}
