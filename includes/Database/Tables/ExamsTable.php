<?php

defined('ABSPATH') || exit;

class ESP_ExamsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_exams(

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            exam_name VARCHAR(150) NOT NULL,

            status TINYINT DEFAULT 1,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id),

            KEY campus_id(campus_id)

        ) {$charset};";

    }

}
