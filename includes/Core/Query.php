<?php

defined('ABSPATH') || exit;

class ESP_Query {

    protected wpdb $db;

    public function __construct() {

        global $wpdb;

        $this->db = $wpdb;

    }

    public function table(

        string $table

    ): string {

        return

            ESP_Database::table(

                $table

            );

    }

}