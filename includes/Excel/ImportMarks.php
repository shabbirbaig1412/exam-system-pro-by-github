<?php

defined('ABSPATH') || exit;

class ESP_ImportMarks {

    public function import(array $rows): int {

        $repository = new ESP_MarksRepository();

        $count = 0;

        foreach ($rows as $row) {

            $repository->save([

                'exam_id'        => $row['Exam ID'],
                'student_id'     => $row['Student ID'],
                'subject_id'     => $row['Subject ID'],
                'obtained_marks' => $row['Marks'],
                'remarks'        => ''

            ]);

            $count++;

        }

        return $count;

    }

}