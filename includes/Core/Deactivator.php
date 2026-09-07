<?php

defined('ABSPATH') || exit;

class ESP_Deactivator {

    public static function deactivate(): void {

        wp_clear_scheduled_hook(

            'esp_daily_cleanup'

        );

        flush_rewrite_rules();

    }

}