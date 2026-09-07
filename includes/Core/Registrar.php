<?php

defined('ABSPATH') || exit;

class ESP_Registrar {

    public static function activate(): void {

        ESP_Installer::install();

    }

    public static function deactivate(): void {

        flush_rewrite_rules();

    }

}