<?php

defined('ABSPATH') || exit;

class ESP_SavePostHook {

    public static function register(): void {

        add_action(

            'save_post',

            [

                self::class,

                'save'

            ],

            10,

            3

        );

    }

    public static function save(

        int $post_id,

        WP_Post $post,

        bool $update

    ): void {

        do_action(

            'esp_save_post',

            $post_id,

            $post,

            $update

        );

    }

}