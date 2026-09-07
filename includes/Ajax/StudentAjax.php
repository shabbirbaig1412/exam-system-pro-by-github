<?php

defined('ABSPATH') || exit;

class ESP_StudentAjax {

    public static function register(): void {

        add_action(

            'esp_save_student',

            [self::class,'save']

        );

        add_action(

            'esp_delete_student',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        (new ESP_StudentController())

            ->save($_POST);

    }

    public static function delete(): void {

        (new ESP_StudentController())

            ->delete(

                (int)$_POST['id']

            );

    }

}