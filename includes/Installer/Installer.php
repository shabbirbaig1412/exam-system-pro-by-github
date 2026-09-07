<?php

defined('ABSPATH') || exit;

class ESP_Installer {

    public static function install(): void {

        ESP_Database::install();

        ESP_Cron::register();

        flush_rewrite_rules();

    }

}