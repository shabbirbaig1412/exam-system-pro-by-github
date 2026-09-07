<?php

defined('ABSPATH') || exit;

class ESP_Request {

    public static function get(

        string $key,

        $default=null

    ){

        return

            $_GET[$key]

            ??

            $default;

    }

    public static function post(

        string $key,

        $default=null

    ){

        return

            $_POST[$key]

            ??

            $default;

    }

    public static function has(

        string $key

    ): bool {

        return

            isset(

                $_REQUEST[$key]

            );

    }

}