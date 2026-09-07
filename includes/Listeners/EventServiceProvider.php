<?php

defined('ABSPATH') || exit;

class ESP_EventServiceProvider {

    public static function register(): void {

        ESP_TeacherCreatedListener::register();

        ESP_StudentCreatedListener::register();

        ESP_ExamCreatedListener::register();

        ESP_MarksSubmittedListener::register();

        ESP_ResultPublishedListener::register();

    }

}