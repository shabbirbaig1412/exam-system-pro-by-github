<?php

defined('ABSPATH') || exit;

class ESP_AdminExamSchedulePage {

    public static function render(): void {

        ESP_Capability::admin();

        ESP_View::render(

            'admin/exam-schedules'

        );

    }

}
