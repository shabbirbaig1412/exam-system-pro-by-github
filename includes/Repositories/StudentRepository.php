<?php

defined('ABSPATH') || exit;

class ESP_StudentRepository extends ESP_CampusAwareRepository {

    protected string $table='esp_students';

    public function all(): array{

        global $wpdb;

        return $wpdb->get_results(

                $wpdb->prepare("SELECT *

                FROM {$this->table}
                WHERE campus_id=%d

                ORDER BY roll_no ASC", ESP_CampusContext::id()),

            ARRAY_A

        );

    }

}
