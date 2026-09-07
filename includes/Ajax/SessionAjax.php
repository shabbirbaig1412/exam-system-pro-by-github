<?php

defined('ABSPATH') || exit;

class ESP_SessionAjax {

    public static function register(): void {

        add_action(

            'esp_save_session',

            [self::class,'save']

        );

        add_action(

            'esp_delete_session',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        (new ESP_SessionController())

            ->save($_POST);

    }

    public static function delete(): void {

        (new ESP_SessionController())

            ->delete(

                (int)$_POST['id']

            );

    }

}