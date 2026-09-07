<?php

defined('ABSPATH') || exit;

class ESP_AllocationsTable {

    public function sql(string $charset): string {

        global $wpdb;

        return "CREATE TABLE {$wpdb->prefix}esp_allocations(

            id BIGINT UNSIGNED AUTO_INCREMENT,

            campus_id BIGINT UNSIGNED NOT NULL DEFAULT 0,

            class_id BIGINT,

            subject_id BIGINT,

            teacher_id BIGINT,

            created_at DATETIME,

            PRIMARY KEY(id),

            UNIQUE KEY class_subject(class_id,subject_id)

        ) {$charset};";

    }

}
