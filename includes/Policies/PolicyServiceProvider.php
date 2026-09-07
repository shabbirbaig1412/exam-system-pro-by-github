<?php

defined('ABSPATH') || exit;

class ESP_PolicyServiceProvider {

    public static function register(): void {

        ESP_Container::singleton(

            ESP_TeacherPolicy::class,

            fn()=>new ESP_TeacherPolicy()

        );

        ESP_Container::singleton(

            ESP_StudentPolicy::class,

            fn()=>new ESP_StudentPolicy()

        );

        ESP_Container::singleton(

            ESP_ExamPolicy::class,

            fn()=>new ESP_ExamPolicy()

        );

        ESP_Container::singleton(

            ESP_MarksPolicy::class,

            fn()=>new ESP_MarksPolicy()

        );

    }

}