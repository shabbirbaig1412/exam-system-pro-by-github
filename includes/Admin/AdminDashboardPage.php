<?php

defined('ABSPATH') || exit;

class ESP_AdminDashboardPage {

    public static function render(): void {

        ESP_Capability::admin();

        ESP_View::render(

            'admin/dashboard'

        );

    }

}
