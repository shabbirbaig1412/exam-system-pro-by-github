<?php

defined('ABSPATH') || exit;

class ESP_ExcelTemplate {

    public function student_template(): array {

        return [[

            'Admission No' => '',

            'Roll No' => '',

            'Student Name' => '',

            'Father Name' => '',

            'Gender' => '',

            'Class ID' => '',

            'Session ID' => '',

            'Mobile' => '',

            'Address' => ''

        ]];

    }

    public function marks_template(): array {

        return [[

            'Exam ID' => '',

            'Student ID' => '',

            'Subject ID' => '',

            'Marks' => ''

        ]];

    }

}