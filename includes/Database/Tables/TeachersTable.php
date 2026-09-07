<?php

defined('ABSPATH') || exit;

class ESP_TeachersTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_teachers(

            id BIGINT UNSIGNED AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            teacher_name VARCHAR(150),

            employee_no VARCHAR(50),

            designation VARCHAR(120),

            mobile VARCHAR(30),

            email VARCHAR(150),

            status TINYINT DEFAULT 1,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id),

            UNIQUE(employee_no)

        ) {$charset};";

    }

}
