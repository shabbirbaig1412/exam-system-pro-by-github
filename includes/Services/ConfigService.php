<?php

defined('ABSPATH') || exit;

class ESP_ConfigService {

    public function get(

        string $key,

        $default = null

    ) {

        return get_option(

            'esp_'.$key,

            $default

        );

    }

    public function set(

        string $key,

        $value

    ): bool {

        return update_option(

            'esp_'.$key,

            $value

        );

    }

}