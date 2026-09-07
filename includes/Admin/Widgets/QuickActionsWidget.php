<?php

defined('ABSPATH') || exit;

class ESP_QuickActionsWidget {

    public static function render(): void {

        ESP_View::render(

            'admin/widgets/quick-actions'

        );

    }

}