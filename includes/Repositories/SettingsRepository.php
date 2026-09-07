<?php

defined('ABSPATH') || exit;

class ESP_SettingsRepository extends ESP_BaseRepository {

    protected string $table;

    public function __construct() {

        parent::__construct();

        $this->table =

            $this->db->prefix.'esp_settings';

    }

    public function all(): array {

        $rows =

            $this->db->get_results(

                "SELECT *

                FROM {$this->table}"

            );

        $settings=[];

        foreach(

            $rows

            as

            $row

        ){

            $settings[

                $row->setting_key

            ]

            =

            $row->setting_value;

        }

        return $settings;

    }

    public function save(

        string $key,

        $value

    ): bool {

        return (bool)

        $this->db->replace(

            $this->table,

            [

                'setting_key'=>$key,

                'setting_value'=>$value

            ]

        );

    }

}