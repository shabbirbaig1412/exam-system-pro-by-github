<?php

defined('ABSPATH') || exit;

function esp_date(

    ?string $date,

    string $format='d M Y'

): string {

    if (

        empty($date)

    ) {

        return '';

    }

    return wp_date(

        $format,

        strtotime($date)

    );

}