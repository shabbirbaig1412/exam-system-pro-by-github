<?php

defined('ABSPATH') || exit;

class ESP_Backup {

    public static function create(): bool {

        do_action(

            'esp_before_backup'

        );

        // Backup implementation
        return true;

    }

    public static function restore(

        string $file

    ): bool {

        do_action(

            'esp_before_restore',

            $file

        );

        return true;

    }

}