<?php

defined('ABSPATH') || exit;

class ESP_SystemHealthService {

    public function check(): array {

        global $wpdb;

        return [

            'php_version'       => PHP_VERSION,

            'wordpress_version' => get_bloginfo('version'),

            'database_version'  => ESP_DB_VERSION,

            'plugin_version'    => ESP_VERSION,

            'database_connected'=> ($wpdb instanceof wpdb),

            'upload_directory'  => wp_upload_dir()['basedir'],

            'memory_limit'      => ini_get('memory_limit'),

            'max_execution'     => ini_get('max_execution_time')

        ];

    }

}