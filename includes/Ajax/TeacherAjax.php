<?php

defined('ABSPATH') || exit;

class ESP_TeacherAjax {

    public static function register(): void {

        add_action(

            'esp_save_teacher',

            [self::class,'save']

        );

        add_action(

            'esp_delete_teacher',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        $controller =

            new ESP_TeacherController();

        $controller->save($_POST);

    }

    public static function delete(): void {

        (new ESP_TeacherController())

            ->delete(

                (int)$_POST['id']

            );

    }

}