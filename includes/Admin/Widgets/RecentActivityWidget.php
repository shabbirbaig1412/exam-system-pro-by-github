<?php

defined('ABSPATH') || exit;

class ESP_RecentActivityWidget {

    public static function render(): void {

        $activities =
            ESP_Container::make(
                ESP_DashboardService::class
            )->recentActivities();

        ESP_View::render(

            'admin/widgets/recent-activity',

            [

                'activities'=>$activities

            ]

        );

    }

}