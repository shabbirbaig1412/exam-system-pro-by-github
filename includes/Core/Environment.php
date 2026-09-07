<?php

defined('ABSPATH') || exit;

class ESP_Environment {

    public static function production(): bool {

        return

            wp_get_environment_type()

            ===

            'production';

    }

    public static function development(): bool {

        return

            wp_get_environment_type()

            ===

            'development';

    }

}