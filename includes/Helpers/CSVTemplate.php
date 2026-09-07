<?php

defined('ABSPATH') || exit;

class ESP_CSVTemplate {

    public static function marks(): void {

        $rows = [

            [

                'student_id'=>'',

                'obtained_marks'=>''

            ]

        ];

        (new ESP_ExportService())

            ->csv(

                $rows,

                'marks-template.csv'

            );

    }

}