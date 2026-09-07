<?php

defined('ABSPATH') || exit;

class ESP_Uninstaller {

    public static function uninstall(): void {

        flush_rewrite_rules();

    }

}