<?php

defined('ABSPATH') || exit;

class ESP_StudentsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_students(

            id BIGINT UNSIGNED AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            admission_no VARCHAR(60),

            roll_no VARCHAR(30),

            student_name VARCHAR(150),

            father_name VARCHAR(150),

            gender VARCHAR(20),

            class_id BIGINT,

            session_id BIGINT,

            mobile VARCHAR(30),

            address TEXT,

            status TINYINT DEFAULT 1,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id),

            UNIQUE(admission_no)

        ) {$charset};";

    }

}
