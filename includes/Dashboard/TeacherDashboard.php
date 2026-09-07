<?php

defined('ABSPATH') || exit;

class ESP_TeacherDashboard {

    public function data(

        int $teacherId

    ): array {

        return [

            'classes'=>ESP_Container::make(
                ESP_ClassRepository::class
            )->teacherClasses($teacherId),

            'subjects'=>ESP_Container::make(
                ESP_SubjectRepository::class
            )->teacherSubjects($teacherId),

            'pending_marks'=>0,

            'completed_marks'=>0

        ];

    }

}