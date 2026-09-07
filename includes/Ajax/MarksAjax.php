<?php

defined('ABSPATH') || exit;

class ESP_MarksAjax {

    public static function register(): void {

        add_action(

            'esp_save_marks',

            [self::class,'save']

        );

    }

    public static function save(): void {

        (new ESP_MarksController())

            ->save($_POST);

    }

}