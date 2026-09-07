<?php

defined('ABSPATH') || exit;

class ESP_ExcelImporter {

    public function importMarks(

        string $csv,

        int $exam_id,

        int $subject_id

    ): int {

        $rows =

            (new ESP_ImportService())

            ->csv($csv);

        $count = 0;

        $repo =

            new ESP_MarksRepository();

        foreach (

            $rows

            as

            $row

        ) {

            if (

                empty($row['student_id'])

            ) {

                continue;

            }

            $repo->saveMarks([

                'exam_id'=>$exam_id,

                'subject_id'=>$subject_id,

                'student_id'=>

                (int)$row['student_id'],

                'obtained_marks'=>

                (float)$row['obtained_marks'],

                'remarks'=>''

            ]);

            $count++;

        }

        return $count;

    }

}