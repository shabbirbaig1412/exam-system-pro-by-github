<?php

defined('ABSPATH') || exit;

class ESP_SubjectAjax {

    public static function register(): void {

        add_action(

            'esp_save_subject',

            [self::class,'save']

        );

        add_action(

            'esp_delete_subject',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        (new ESP_SubjectController())

            ->save($_POST);

    }

    public static function delete(): void {

        (new ESP_SubjectController())

            ->delete(

                (int)$_POST['id']

            );

    }

}