<?php

defined('ABSPATH') || exit;

class ESP_MarksTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_marks(

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            exam_id BIGINT UNSIGNED NOT NULL,

            student_id BIGINT UNSIGNED NOT NULL,

            subject_id BIGINT UNSIGNED NOT NULL,

            obtained_marks DECIMAL(10,2) DEFAULT 0,

            remarks VARCHAR(255),

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id),

            UNIQUE KEY exam_student_subject(exam_id,student_id,subject_id),

            KEY exam_id(exam_id),

            KEY student_id(student_id),

            KEY subject_id(subject_id)

        ) {$charset};";

    }

}
