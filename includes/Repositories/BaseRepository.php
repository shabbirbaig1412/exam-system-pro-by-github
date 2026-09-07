<?php

defined('ABSPATH') || exit;

abstract class ESP_BaseRepository {

    use ESP_CrudTrait;

    protected wpdb $db;

    protected string $table='';

    public function __construct() {

        global $wpdb;

        $this->db = $wpdb;

        if (isset($this->table) && $this->table !== '') {
            $this->table = ESP_Database::table($this->table);
        }

    }

}
