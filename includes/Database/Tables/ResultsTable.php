<?php

defined('ABSPATH') || exit;

class ESP_ResultsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_results(

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            exam_id BIGINT UNSIGNED NOT NULL,

            student_id BIGINT UNSIGNED NOT NULL,

            total_marks DECIMAL(10,2),

            obtained_marks DECIMAL(10,2),

            percentage DECIMAL(6,2),

            grade VARCHAR(20),

            remarks VARCHAR(100),

            status VARCHAR(20),

            position INT DEFAULT 0,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id),

            UNIQUE KEY exam_student(exam_id,student_id),

            KEY exam_id(exam_id),

            KEY student_id(student_id),

            KEY position(position)

        ) {$charset};";

    }

}
