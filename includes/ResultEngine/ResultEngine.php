<?php

defined('ABSPATH') || exit;

class ESP_ResultEngine {

    private ESP_GradeEngine $grade;

    private ESP_RemarksEngine $remarks;

    private ESP_PositionEngine $position;

    private ESP_ResultValidator $validator;

    private ESP_ResultRepository $repository;

    public function __construct() {

        $this->grade = new ESP_GradeEngine();

        $this->remarks = new ESP_RemarksEngine();

        $this->position = new ESP_PositionEngine();

        $this->validator = new ESP_ResultValidator();

        $this->repository = new ESP_ResultRepository();

    }

    public function generate(int $exam_id): bool {

        global $wpdb;

        $exam = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT id, session_id, campus_id
                 FROM {$wpdb->prefix}esp_exams
                 WHERE id=%d
                 AND campus_id=%d",
                $exam_id,
                ESP_CampusContext::id()
            ),
            ARRAY_A
        );

        if (!$exam) {
            return false;
        }

        $pass_percentage = (float) ESP_Common::option(
            'default_pass_percentage',
            33
        );

        $students = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT DISTINCT m.student_id
                 FROM {$wpdb->prefix}esp_marks m
                 INNER JOIN {$wpdb->prefix}esp_students st ON st.id=m.student_id AND st.campus_id=m.campus_id
                 WHERE m.exam_id=%d
                 AND m.campus_id=%d
                 AND st.campus_id=%d",
                $exam_id,
                $exam['campus_id'],
                $exam['campus_id']
            ),
            ARRAY_A
        );

        $results = [];

        foreach ($students as $student) {
            $subjects = $wpdb->get_results(
                $wpdb->prepare(
                    "SELECT m.*,
                            s.passing_marks,
                            s.total_marks
                     FROM {$wpdb->prefix}esp_marks m
                     INNER JOIN {$wpdb->prefix}esp_subjects s ON s.id=m.subject_id AND s.campus_id=m.campus_id
                     WHERE m.exam_id=%d
                     AND m.student_id=%d
                     AND m.campus_id=%d",
                    $exam_id,
                    $student['student_id'],
                    $exam['campus_id']
                ),
                ARRAY_A
            );

            $obtained = 0;

            $total = 0;

            foreach ($subjects as $subject) {

                $obtained += $subject['obtained_marks'];

                $total += $subject['total_marks'];

            }

            $percentage = $total > 0

                ? round(($obtained / $total) * 100, 2)

                : 0;

            $pass = $this->validator->passed(

                $subjects,

                $percentage,

                $pass_percentage

            );

            $results[] = [

                'exam_id' => $exam_id,

                'student_id' => $student['student_id'],

                'campus_id' => $exam['campus_id'],

                'total_marks' => $total,

                'obtained_marks' => $obtained,

                'percentage' => $percentage,

                'grade' => $this->grade->grade($percentage),

                'remarks' => $this->remarks->remark(

                    $percentage,

                    $pass

                ),

                'status' => $pass ? 'PASS' : 'FAIL'

            ];

        }

        $results = $this->position->assign($results);

        foreach ($results as $row) {

            $this->repository->save($row);

        }

        return true;

    }

}
