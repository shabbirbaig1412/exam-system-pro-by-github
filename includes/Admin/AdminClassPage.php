<?php

defined('ABSPATH') || exit;

class ESP_AdminClassPage {

    public static function render(): void {

        ESP_Capability::admin();

        ESP_View::render(

            'admin/classes'

        );

    }

}
