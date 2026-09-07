<?php

defined('ABSPATH') || exit;

class ESP_TeacherRepository extends ESP_CampusAwareRepository {

    protected string $table='esp_teachers';

    public function all(): array{

        global $wpdb;

        return $wpdb->get_results(

                $wpdb->prepare("SELECT *

                FROM {$this->table}
                WHERE campus_id=%d

                ORDER BY teacher_name", ESP_CampusContext::id()),

            ARRAY_A

        );

    }

    public function active(): array {
        global $wpdb;
        return $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM {$this->table} WHERE status=1 AND campus_id=%d ORDER BY teacher_name",
            ESP_CampusContext::id()
        ), ARRAY_A);
    }

}
