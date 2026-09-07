<?php

defined('ABSPATH') || exit;

class ESP_Ajax {

    public static function register(): void {

        ESP_Ajax_Teacher::register();
        ESP_Ajax_Student::register();
        ESP_Ajax_Class::register();
        ESP_Ajax_Subject::register();
        ESP_Ajax_Exam::register();
        ESP_Ajax_Marks::register();
        ESP_Ajax_Result::register();
        ESP_Ajax_Report::register();
        ESP_Ajax_Dashboard::register();
        ESP_Ajax_Campus::register();
        ESP_Ajax_MarksLoader::register();
        ESP_Ajax_SchoolSettings::register();
        ESP_Ajax_Resubmit::register();

    }

}
