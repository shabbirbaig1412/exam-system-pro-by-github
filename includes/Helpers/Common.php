<?php

defined('ABSPATH') || exit;

class ESP_Common {

    public static function option(

        string $key,

        $default=null

    ){

        static $settings=null;

        if(

            $settings===null

        ){

            $settings=

            (new ESP_SettingsRepository())

            ->all();

        }

        return

        $settings[$key]

        ??

        $default;

    }

    public static function now(): string {

        return current_time(

            'mysql'

        );

    }

}