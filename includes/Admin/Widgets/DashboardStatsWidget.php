<?php

defined('ABSPATH') || exit;

class ESP_DashboardStatsWidget {

    public static function render(): void {

        $stats =
            ESP_Container::make(
                ESP_DashboardService::class
            )->statistics();

        ESP_View::render(

            'dashboard/widgets',

            [

                'stats'=>$stats

            ]

        );

    }

}
