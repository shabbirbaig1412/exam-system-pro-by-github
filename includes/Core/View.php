<?php

defined('ABSPATH') || exit;

class ESP_View {

    public static function render(

        string $view,

        array $data=[]

    ): void {

        extract($data);

        // Older admin page classes include the `admin/` directory in their
        // view name, while this renderer already starts in templates/admin.
        // Accept both forms so menu callbacks always resolve the same file.
        $view = preg_replace('#^admin/#', '', $view);

        $file =

            ESP_PATH.

            'templates/admin/'.

            $view.

            '.php';

        if(

            file_exists($file)

        ){

            require $file;

            return;

        }

        wp_die(

            'View not found: '.$view

        );

    }

}
