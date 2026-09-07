<?php

defined('ABSPATH') || exit;

class ESP_SchoolSettings {

    const OPTION = 'esp_school_settings';

    public static function get(): array {

        return wp_parse_args(

            get_option(

                self::OPTION,

                []

            ),

            [

                'school_name'=>'',

                'school_code'=>'',

                'address'=>'',

                'phone'=>'',

                'email'=>'',

                'website'=>'',

                'logo'=>'',

                'principal'=>'',

                'principal_signature'=>'',

                'controller'=>'',

                'controller_signature'=>'',

                'school_stamp'=>'',

                'result_footer'=>'',

                'report_header'=>''

            ]

        );

    }

}