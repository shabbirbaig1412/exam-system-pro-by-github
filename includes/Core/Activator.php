<?php

defined('ABSPATH') || exit;

class ESP_Activator {

    public static function activate(): void {

        ESP_Database::install();

        ESP_Seeder::seed();

        ESP_Cron::register();

        flush_rewrite_rules();

    }

}