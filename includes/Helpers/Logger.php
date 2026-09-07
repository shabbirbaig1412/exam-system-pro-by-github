<?php

defined('ABSPATH') || exit;

class ESP_Logger {

    public static function info(string $message): void {

        self::log('INFO: '.$message);

    }

    public static function error(string $message): void {

        self::log('ERROR: '.$message);

    }

    public static function log(

        string $action

    ): void {

        global $wpdb;

        $wpdb->insert(

            $wpdb->prefix.'esp_logs',

            [

                'user_id'=>get_current_user_id(),

                'action'=>$action,

                'created_at'=>current_time('mysql')

            ]

        );

    }

}
