<?php

defined('ABSPATH') || exit;

class ESP_AdminTeacherPage {

    public static function render(): void {

        ESP_Capability::admin();

        ESP_View::render(

            'admin/teachers'

        );

    }

}
