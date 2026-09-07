<?php

defined('ABSPATH') || exit;

class ESP_ClassRepository extends ESP_CampusAwareRepository {

    protected string $table='esp_classes';

    public function all(): array{

        global $wpdb;

        return $wpdb->get_results(

                $wpdb->prepare("SELECT *

                FROM {$this->table}
                WHERE campus_id=%d

                ORDER BY sort_order, class_name", ESP_CampusContext::id()),

            ARRAY_A

        );

    }

}
