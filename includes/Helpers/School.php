<?php

defined('ABSPATH') || exit;

class ESP_School {

    public static function name(): string {

        return ESP_Common::option(

            'school_name',

            get_bloginfo(

                'name'

            )

        );

    }

    public static function address(): string {

        return ESP_Common::option(

            'school_address',

            ''

        );

    }

    public static function phone(): string {

        return ESP_Common::option(

            'school_phone',

            ''

        );

    }

    public static function email(): string {

        return ESP_Common::option(

            'school_email',

            get_bloginfo(

                'admin_email'

            )

        );

    }

}