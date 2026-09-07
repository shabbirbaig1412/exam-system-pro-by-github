<?php

defined('ABSPATH') || exit;

class ESP_Str {

    public static function limit(

        string $text,

        int $words=20

    ): string {

        return wp_trim_words(

            $text,

            $words

        );

    }

    public static function slug(

        string $text

    ): string {

        return sanitize_title(

            $text

        );

    }

    public static function random(

        int $length=16

    ): string {

        return wp_generate_password(

            $length,

            false,

            false

        );

    }

}