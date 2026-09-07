<?php

defined('ABSPATH') || exit;

class ESP_Seeder {

    public static function seed(): void {

        global $wpdb;

        if (

            !$wpdb->get_var(

                "SELECT COUNT(*)

                FROM {$wpdb->prefix}esp_settings"

            )

        ) {

            $settings = [

                'school_name'=>'',

                'school_address'=>'',

                'school_phone'=>'',

                'school_email'=>'',

                'default_pass_percentage'=>'33',

                'grade_system'=>'default',

                'result_decimals'=>'2'

            ];

            foreach (

                $settings

                as

                $key=>$value

            ) {

                $wpdb->insert(

                    $wpdb->prefix.'esp_settings',

                    [

                        'setting_key'=>$key,

                        'setting_value'=>$value

                    ]

                );

            }

        }

    }

}