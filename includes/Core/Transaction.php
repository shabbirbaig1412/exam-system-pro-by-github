<?php

defined('ABSPATH') || exit;

class ESP_Transaction {

    public static function begin(): void {

        global $wpdb;

        $wpdb->query(

            'START TRANSACTION'

        );

    }

    public static function commit(): void {

        global $wpdb;

        $wpdb->query(

            'COMMIT'

        );

    }

    public static function rollback(): void {

        global $wpdb;

        $wpdb->query(

            'ROLLBACK'

        );

    }

}