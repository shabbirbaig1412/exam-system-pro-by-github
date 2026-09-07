<?php

defined('ABSPATH') || exit;

class ESP_SubjectRepository extends ESP_CampusAwareRepository {

    protected string $table='esp_subjects';

    public function all(): array{

        global $wpdb;

        return $wpdb->get_results(

                $wpdb->prepare("SELECT *

                FROM {$this->table}
                WHERE campus_id=%d

                ORDER BY subject_name", ESP_CampusContext::id()),

            ARRAY_A

        );

    }

}
