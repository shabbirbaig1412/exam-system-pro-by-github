<?php

defined('ABSPATH') || exit;

class ESP_LogRepository extends ESP_BaseRepository {

    protected string $table;

    public function __construct() {

        parent::__construct();

        $this->table =

            $this->db->prefix.'esp_logs';

    }

    public function latest(

        int $limit=100

    ): array {

        return $this->db->get_results(

            $this->db->prepare(

                "SELECT *

                FROM {$this->table}

                ORDER BY id DESC

                LIMIT %d",

                $limit

            )

        );

    }

}