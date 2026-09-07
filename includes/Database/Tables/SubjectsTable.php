<?php

defined('ABSPATH') || exit;

class ESP_SubjectsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_subjects(

            id BIGINT UNSIGNED AUTO_INCREMENT,

            subject_name VARCHAR(150),

            subject_code VARCHAR(50),

            total_marks DECIMAL(8,2),

            passing_marks DECIMAL(8,2),

            status TINYINT DEFAULT 1,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id)

        ) {$charset};";

    }

}