<?php

defined('ABSPATH') || exit;

class ESP_CampusRepository extends ESP_BaseRepository {

    protected string $table = 'esp_campuses';

    public function all(): array {

        global $wpdb;

        return $wpdb->get_results(

            "SELECT * FROM {$this->table}
            ORDER BY name ASC",

            ARRAY_A

        );

    }

    public function find(

        int $id

    ): ?array {

        global $wpdb;

        return $wpdb->get_row(

            $wpdb->prepare(

                "SELECT *
                FROM {$this->table}
                WHERE id=%d",

                $id

            ),

            ARRAY_A

        );

    }

}