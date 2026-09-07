<?php

defined('ABSPATH') || exit;

class ESP_Nonce {

    const ACTION = 'esp_nonce';

    public static function field(): void {

        wp_nonce_field(

            self::ACTION,

            '_wpnonce'

        );

    }

    public static function verify(): bool {

        return isset(

            $_REQUEST['_wpnonce']

        )

        &&

        wp_verify_nonce(

            $_REQUEST['_wpnonce'],

            self::ACTION

        );

    }

    public static function verifyOrDie(): void {

        check_admin_referer(

            self::ACTION

        );

    }

}