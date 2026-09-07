<?php

defined('ABSPATH') || exit;

class ESP_AdminSettingsPage {

    public static function render(): void {

        ESP_Capability::admin();
        ESP_View::render('admin/settings-school', [
            'settings' => ESP_SchoolSettings::get(),
        ]);

    }

}
