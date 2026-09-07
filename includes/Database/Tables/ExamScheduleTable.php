<?php

defined('ABSPATH') || exit;

class ESP_ExamScheduleTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_exam_schedules(

            id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            exam_id BIGINT UNSIGNED NOT NULL,

            class_id BIGINT UNSIGNED NOT NULL,

            exam_date DATE,

            start_time TIME,

            end_time TIME,

            remarks VARCHAR(255),

            status TINYINT DEFAULT 1,

            created_at DATETIME,

            updated_at DATETIME,

            PRIMARY KEY(id),

            UNIQUE KEY exam_class(campus_id,exam_id,class_id),

            KEY exam_id(exam_id),

            KEY class_id(class_id),

            KEY campus_id(campus_id)

        ) {$charset};";

    }

}
