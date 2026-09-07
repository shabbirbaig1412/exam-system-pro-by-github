<?php

defined('ABSPATH') || exit;

class ESP_Assets {

    public static function css(string $file, array $deps = []): void {

        wp_enqueue_style('esp-'.$file, ESP_URL.'assets/css/'.$file.'.css', $deps, ESP_VERSION);

    }

    public static function js(string $file, array $deps = ['jquery']): void {

        wp_enqueue_script('esp-'.$file, ESP_URL.'assets/js/'.$file.'.js', $deps, ESP_VERSION, true);

    }

    public static function register(): void {

        add_action(

            'admin_enqueue_scripts',

            [self::class,'load']

        );

    }

    public static function load(): void {

        if (!is_admin()) {
            return;
        }

        wp_enqueue_style(

            'esp-admin',

            ESP_URL.'assets/css/admin.css',

            [],

            ESP_VERSION

        );

        wp_enqueue_script(

            'esp-admin',

            ESP_URL.'assets/js/admin.js',

            ['jquery'],

            ESP_VERSION,

            true

        );

        wp_localize_script(

            'esp-admin',

            'ESP',

            [

                'ajax'=>admin_url('admin-ajax.php'),

                'nonce'=>wp_create_nonce('esp_nonce')

            ]

        );

        self::js('campus-selector');
        self::js('record-filters');

        $screen = function_exists('get_current_screen') ? get_current_screen() : null;
        $page = $screen ? ($screen->id ?? '') : '';
        if (str_contains($page, 'esp-marks')) {
            self::css('marks-entry');
            self::css('marks-excel');
            self::js('marks-progress');
            self::js('marks-validation');
            self::js('marks-navigation');
            self::js('marks-loader');
            self::js('marks-save');
            self::js('marks-paste');
            self::js('marks-resubmit');
            self::js('marks-shortcuts');
            self::js('marks-submit');
        }

    }

}
