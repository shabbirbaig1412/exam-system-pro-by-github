<?php

defined('ABSPATH') || exit;

class ESP_DateHelper {

    public static function display(

        $date

    ): string {

        if (

            empty($date)

        ) {

            return '';

        }

        return wp_date(

            get_option(

                'date_format'

            ),

            strtotime($date)

        );

    }

}