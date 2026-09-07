<?php

defined('ABSPATH') || exit;

class ESP_Migration {

    public static function run(): void {

        // Repair the campus columns even when an older installation already
        // has the latest stored database version.
        ESP_Database::ensure_campus_columns();

        $current =

            get_option(

                'esp_db_version',

                '0'

            );

        if (

            version_compare(

                $current,

                ESP_DB_VERSION,

                '<'

            )

        ) {

            ESP_Database::install();

            update_option(
                'esp_db_version',
                ESP_DB_VERSION
            );
        }

        self::repairExamStatuses();
    }

    private static function repairExamStatuses(): void {
        global $wpdb;

        // Older record forms omitted status, which stored exams and schedules
        // as inactive. These are the only status-bearing records created by
        // those forms, so restore them to the intended active default.
        $wpdb->query("UPDATE {$wpdb->prefix}esp_exams SET status=1 WHERE status=0");
        $wpdb->query("UPDATE {$wpdb->prefix}esp_exam_schedules SET status=1 WHERE status=0");
    }

}
