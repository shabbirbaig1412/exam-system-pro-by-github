<?php

defined('ABSPATH') || exit;

class ESP_AllocationAjax {

    public static function register(): void {

        add_action(

            'esp_save_allocation',

            [self::class,'save']

        );

        add_action(

            'esp_delete_allocation',

            [self::class,'delete']

        );

    }

    public static function save(): void {

        (new ESP_AllocationController())

            ->save($_POST);

    }

    public static function delete(): void {

        (new ESP_AllocationController())

            ->delete(

                (int)$_POST['id']

            );

    }

}