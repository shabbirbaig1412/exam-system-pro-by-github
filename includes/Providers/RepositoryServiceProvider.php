<?php

defined('ABSPATH') || exit;

class ESP_RepositoryServiceProvider {

    public static function register(): void {

        ESP_Container::singleton(

            ESP_SessionRepository::class,

            fn() => new ESP_SessionRepository()

        );

        ESP_Container::singleton(

            ESP_ClassRepository::class,

            fn() => new ESP_ClassRepository()

        );

        ESP_Container::singleton(

            ESP_TeacherRepository::class,

            fn() => new ESP_TeacherRepository()

        );

        ESP_Container::singleton(

            ESP_StudentRepository::class,

            fn() => new ESP_StudentRepository()

        );

        ESP_Container::singleton(

            ESP_SubjectRepository::class,

            fn() => new ESP_SubjectRepository()

        );

        ESP_Container::singleton(

            ESP_ExamRepository::class,

            fn() => new ESP_ExamRepository()

        );

        ESP_Container::singleton(

            ESP_MarksRepository::class,

            fn() => new ESP_MarksRepository()

        );

        ESP_Container::singleton(

            ESP_ResultRepository::class,

            fn() => new ESP_ResultRepository()

        );

    }

}