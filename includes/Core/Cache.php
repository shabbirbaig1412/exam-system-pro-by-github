<?php

defined('ABSPATH') || exit;

class ESP_Cache {

    public static function remember(

        string $key,

        callable $callback,

        int $seconds=300

    ){

        $value =

            get_transient($key);

        if(

            $value!==false

        ){

            return $value;

        }

        $value =

            $callback();

        set_transient(

            $key,

            $value,

            $seconds

        );

        return $value;

    }

    public static function forget(

        string $key

    ): void {

        delete_transient(

            $key

        );

    }

}