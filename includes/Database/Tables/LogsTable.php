<?php

defined('ABSPATH') || exit;

class ESP_LogsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_logs(

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            log_level VARCHAR(20),

            message LONGTEXT,

            user_id BIGINT UNSIGNED DEFAULT 0,

            ip_address VARCHAR(45),

            created_at DATETIME,

            PRIMARY KEY(id),

            KEY created_at(created_at),

            KEY log_level(log_level)

        ) {$charset};";

    }

}