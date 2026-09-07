<?php

defined('ABSPATH') || exit;

class ESP_ClassesTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_classes(

            id BIGINT UNSIGNED AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            class_name VARCHAR(120),

            sort_order INT DEFAULT 0,

            status TINYINT DEFAULT 1,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id)

        ) {$charset};";

    }

}
