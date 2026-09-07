<?php

defined('ABSPATH') || exit;

class ESP_AdminSessionPage {

    public static function render(): void {

        ESP_Capability::admin();
        $sessions = (new ESP_SessionRepository())->all();
        ESP_View::render('admin/sessions', ['sessions' => $sessions]);

    }

}
