<?php

defined('ABSPATH') || exit;

class ESP_Autoloader {

    public static function register(): void {

        spl_autoload_register(

            [self::class,'load']

        );

    }

    public static function load(

        string $class

    ): void {

        if (

            strpos(

                $class,

                'ESP_'

            ) !== 0

        ) {

            return;

        }

        $requestedClass = $class;

        $class =

            str_replace(

                'ESP_',

                '',

                $class

            );

        $class =

            str_replace(

                '_',

                DIRECTORY_SEPARATOR,

                $class

            );

        $paths = [

            ESP_PATH.'includes/',

            ESP_PATH.'includes/Core/',

            ESP_PATH.'includes/Hooks/',

            ESP_PATH.'includes/Assets/',

            ESP_PATH.'includes/Controllers/',

            ESP_PATH.'includes/Repositories/',

            ESP_PATH.'includes/Services/',

            ESP_PATH.'includes/Helpers/',

            ESP_PATH.'includes/Admin/',
            ESP_PATH.'includes/Admin/Widgets/',
            ESP_PATH.'includes/Admin/ListTables/',

            ESP_PATH.'includes/Menu/',

            ESP_PATH.'includes/Ajax/',

            ESP_PATH.'includes/Database/',

            ESP_PATH.'includes/Traits/',

            ESP_PATH.'includes/Models/',

            // Contracts
            ESP_PATH.'includes/Contracts/',

            // Other directories
            ESP_PATH.'includes/Reports/',
            ESP_PATH.'includes/Providers/',
            ESP_PATH.'includes/Observers/',
            ESP_PATH.'includes/Policies/',
            ESP_PATH.'includes/Support/',
            ESP_PATH.'includes/Notifications/',
            ESP_PATH.'includes/Security/',
            ESP_PATH.'includes/Dashboard/',
            ESP_PATH.'includes/DTOs/',
            ESP_PATH.'includes/Events/',
            ESP_PATH.'includes/Excel/',
            ESP_PATH.'includes/Exceptions/',
            ESP_PATH.'includes/Export/',
            ESP_PATH.'includes/Factories/',
            ESP_PATH.'includes/Installer/',
            ESP_PATH.'includes/Listeners/',
            ESP_PATH.'includes/Logs/',
            ESP_PATH.'includes/PDF/',
            ESP_PATH.'includes/ResultEngine/',
            ESP_PATH.'includes/Results/',
            ESP_PATH.'includes/Settings/',
            ESP_PATH.'includes/System/'

        ];

        foreach ($paths as $path) {

            $file =

                $path.$class.'.php';

            if (

                file_exists($file)

            ) {

                require_once $file;

                // Continue past legacy filename collisions when the file
                // does not define the class that was requested.
                if (class_exists($requestedClass, false)) {

                    return;

                }

            }

            // The AJAX classes use the historical ESP_Ajax_Foo class name
            // while their files are stored as AjaxFoo.php. Keep supporting
            // that naming convention so the AJAX bootstrap can autoload
            // every registered handler during plugin activation.
            if (strpos($class, 'Ajax'.DIRECTORY_SEPARATOR) === 0) {

                $legacyFile = $path.str_replace(

                    'Ajax'.DIRECTORY_SEPARATOR,

                    'Ajax',

                    $class

                ).'.php';

                if (file_exists($legacyFile)) {

                    require_once $legacyFile;

                    if (class_exists($requestedClass, false)) {

                        return;

                    }

                }

            }

        }

    }

}
