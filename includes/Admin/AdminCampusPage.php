<?php

defined('ABSPATH') || exit;

class ESP_AdminCampusPage {

    public static function render(): void {

        if (!ESP_CampusContext::can_manage_registry()) {
            wp_die(esc_html__('You do not have permission to manage campuses.', 'exam-system-pro'));
        }

        $campuses = (new ESP_CampusRepository())->all();
        ESP_View::render('admin/campuses', ['campuses' => $campuses]);
    }
}
