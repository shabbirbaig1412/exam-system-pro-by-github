<?php

defined('ABSPATH') || exit;

class ESP_Config {

    public static function get(

        string $key,

        $default = null

    ) {

        static $settings = null;

        if (

            $settings === null

        ) {

            $settings =

                (new ESP_SettingsRepository())

                ->all();

        }

        return

            $settings[$key]

            ??

            $default;

    }

}