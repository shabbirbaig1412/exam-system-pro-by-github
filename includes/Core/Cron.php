<?php

defined('ABSPATH') || exit;

class ESP_Cron {

    public static function register(): void {

        add_action(

            'esp_daily_cleanup',

            [self::class,'cleanup']

        );

        if (

            !wp_next_scheduled(

                'esp_daily_cleanup'

            )

        ) {

            wp_schedule_event(

                time(),

                'daily',

                'esp_daily_cleanup'

            );

        }

    }

    public static function cleanup(): void {

        global $wpdb;

        $wpdb->query(

            "DELETE FROM {$wpdb->prefix}esp_logs

            WHERE created_at < DATE_SUB(NOW(),INTERVAL 90 DAY)"

        );

    }

}