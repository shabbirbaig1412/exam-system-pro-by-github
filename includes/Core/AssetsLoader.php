<?php

defined('ABSPATH') || exit;

class ESP_AssetsLoader {

    public static function register(): void {
        // Proxy to the real assets class if present
        if (class_exists('ESP_Assets', true)) {
            ESP_Assets::register();
            return;
        }

        // Fallback: try to require known file (best-effort)
        $file = ESP_PATH . 'includes/Assets/Assets.php';
        if (file_exists($file)) {
            require_once $file;
            if (class_exists('ESP_Assets')) {
                ESP_Assets::register();
            }
        }
    }

}
