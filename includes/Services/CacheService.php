<?php

defined('ABSPATH') || exit;

class ESP_CacheService {

    public function get(

        string $key,

        $default = null

    ) {

        $value = wp_cache_get(

            $key,

            'esp'

        );

        return

            $value === false

            ?

            $default

            :

            $value;

    }

    public function put(

        string $key,

        $value,

        int $ttl = 3600

    ): void {

        wp_cache_set(

            $key,

            $value,

            'esp',

            $ttl

        );

    }

    public function forget(

        string $key

    ): void {

        wp_cache_delete(

            $key,

            'esp'

        );

    }

}