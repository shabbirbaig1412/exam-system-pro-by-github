<?php

defined('ABSPATH') || exit;

class ESP_SessionRepository extends ESP_BaseRepository {

    protected string $table='esp_sessions';

    public function all(): array {
        return $this->db->get_results(
            "SELECT * FROM {$this->table} ORDER BY start_date DESC, id DESC",
            ARRAY_A
        );
    }

}
