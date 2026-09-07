<?php

defined('ABSPATH') || exit;

class ESP_StudentPromotionService {

    public function promote(

        array $studentIds,

        int $newSession,

        int $newClass

    ): int {

        global $wpdb;

        $count = 0;
        $campus = ESP_CampusContext::id();
        $current_session = ESP_SessionContext::id();
        $valid_session = (int) $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_sessions WHERE id=%d", $newSession));
        $valid_class = (int) $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_classes WHERE id=%d AND campus_id=%d", $newClass, $campus));
        if (!$campus || !$valid_session || !$valid_class) return 0;

        foreach (

            $studentIds

            as

            $id

        ) {

            $updated =

                $wpdb->update(

                    $wpdb->prefix.'esp_students',

                    [

                        'session_id'=>$newSession,

                        'class_id'=>$newClass,

                        'updated_at'=>current_time('mysql')

                    ],

                    [

                        'id'=>(int)$id,
                        'campus_id'=>$campus,
                        'session_id'=>$current_session

                    ]

                );

            if (

                $updated !== false

            ) {

                $count++;

            }

        }

        return $count;

    }

}
