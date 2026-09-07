<?php

defined('ABSPATH') || exit;

class ESP_AllocationEngine {

    public static function teacherSubjects(

        int $teacher_id

    ): array {

        global $wpdb;

        return $wpdb->get_results(

            $wpdb->prepare(

                "SELECT *

                 FROM {$wpdb->prefix}esp_allocations

                 WHERE teacher_id=%d",

                 $teacher_id

            )

        );

    }

    public static function classSubjects(

        int $class_id

    ): array {

        global $wpdb;

        return $wpdb->get_results(

            $wpdb->prepare(

                "SELECT *

                 FROM {$wpdb->prefix}esp_allocations

                 WHERE class_id=%d",

                 $class_id

            )

        );

    }

}