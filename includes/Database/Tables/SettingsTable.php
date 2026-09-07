<?php

defined('ABSPATH') || exit;

class ESP_SettingsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_settings(

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            setting_key VARCHAR(150) NOT NULL,

            setting_value LONGTEXT,

            PRIMARY KEY(id),

            UNIQUE KEY setting_key(setting_key)

        ) {$charset};";

    }

}