<?php

defined('ABSPATH') || exit;

class ESP_SystemHealthWidget {

    public static function render(): void {

        $health =
            ESP_Container::make(
                ESP_SystemService::class
            )->health();

        ESP_View::render(

            'admin/widgets/system-health',

            [

                'health'=>$health

            ]

        );

    }

}