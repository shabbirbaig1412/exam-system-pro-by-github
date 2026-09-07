<?php

defined('ABSPATH') || exit;

function esp_limit(

    string $text,

    int $length=100

): string {

    return wp_trim_words(

        $text,

        $length

    );

}

function esp_clean(

    string $text

): string {

    return sanitize_text_field(

        $text

    );

}