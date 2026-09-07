<?php

defined('ABSPATH') || exit;

class ESP_ClassAjax {

    public static function register(): void {

        add_action(

            'esp_save_class',

            [self::class,'save']

        );

        add_action(

            'esp_delete_class',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        (new ESP_ClassController())

            ->save($_POST);

    }

    public static function delete(): void {

        (new ESP_ClassController())

            ->delete(

                (int)$_POST['id']

            );

    }

}