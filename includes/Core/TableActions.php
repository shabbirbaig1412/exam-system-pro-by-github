<?php

defined('ABSPATH') || exit;

class ESP_TableActions {

    public static function edit(

        int $id

    ): string {

        return sprintf(

            '<a href="#" class="esp-edit" data-id="%d">Edit</a>',

            $id

        );

    }

    public static function delete(

        int $id,

        string $action

    ): string {

        return sprintf(

            '<a href="#" class="esp-delete" data-id="%d" data-action="%s">Delete</a>',

            $id,

            esc_attr($action)

        );

    }

}