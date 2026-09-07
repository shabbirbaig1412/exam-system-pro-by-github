<?php

defined('ABSPATH') || exit;

class ESP_ReportEngine {

    public static function reportCard(

        int $exam_id,

        int $student_id

    ): array {

        $student =

            (new ESP_StudentRepository())

            ->find($student_id);

        $exam =

            (new ESP_ExamRepository())

            ->find($exam_id);

        $marks =

            (new ESP_MarksRepository())

            ->studentMarks(

                $exam_id,

                $student_id

            );

        $result = null;

        $results =

            (new ESP_ResultRepository())

            ->examResults($exam_id);

        foreach ($results as $row) {

            if (

                (int)$row->student_id === $student_id

            ) {

                $result = $row;

                break;

            }

        }

        return [

            'student' => $student,

            'exam'    => $exam,

            'marks'   => $marks,

            'result'  => $result

        ];

    }

}