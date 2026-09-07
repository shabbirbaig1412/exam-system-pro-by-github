<?php

defined('ABSPATH') || exit;

class ESP_ImportStudents {

    public function import(array $rows): int {

        $repository = new ESP_StudentRepository();

        $count = 0;

        foreach ($rows as $row) {

            $repository->save([

                'admission_no' => $row['Admission No'],
                'roll_no'      => $row['Roll No'],
                'student_name' => $row['Student Name'],
                'father_name'  => $row['Father Name'],
                'gender'       => $row['Gender'],
                'class_id'     => $row['Class ID'],
                'session_id'   => $row['Session ID'],
                'mobile'       => $row['Mobile'],
                'address'      => $row['Address'],
                'status'       => 1

            ]);

            $count++;

        }

        return $count;

    }

}