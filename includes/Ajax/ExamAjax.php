<?php

defined('ABSPATH') || exit;

class ESP_ExamAjax {

    public static function register(): void {

        add_action(

            'esp_save_exam',

            [self::class,'save']

        );

        add_action(

            'esp_delete_exam',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        (new ESP_ExamController())

            ->save($_POST);

    }

    public static function delete(): void {

        (new ESP_ExamController())

            ->delete(

                (int)$_POST['id']

            );

    }

}