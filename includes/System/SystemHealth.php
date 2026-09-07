<?php

defined('ABSPATH') || exit;

class ESP_SystemHealth {

    public function report(): array {

        global $wpdb;

        return [

            'php'=>PHP_VERSION,

            'wordpress'=>get_bloginfo('version'),

            'database'=>$wpdb->db_version(),

            'memory'=>ini_get('memory_limit'),

            'upload'=>wp_max_upload_size()

        ];

    }

}