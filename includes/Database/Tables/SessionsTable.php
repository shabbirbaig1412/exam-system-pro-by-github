<?php

defined('ABSPATH') || exit;

class ESP_SessionsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_sessions(

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            session_name VARCHAR(100) NOT NULL,

            start_date DATE,

            end_date DATE,

            is_active TINYINT DEFAULT 0,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id)

        ) {$charset};";

    }

}