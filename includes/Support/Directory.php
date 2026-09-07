<?php

defined('ABSPATH') || exit;

class ESP_Directory {

    public static function make(

        string $path

    ): bool {

        if (

            is_dir($path)

        ) {

            return true;

        }

        return wp_mkdir_p(

            $path

        );

    }

}