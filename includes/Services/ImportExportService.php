<?php

defined('ABSPATH') || exit;

class ESP_ImportExportService {

    public function exportStudents(): void {

        $rows =

            (new ESP_StudentRepository())

            ->all();

        (new ESP_ExportService())

            ->csv(

                $rows,

                'students.csv'

            );

    }

    public function exportTeachers(): void {

        $rows =

            (new ESP_TeacherRepository())

            ->all();

        (new ESP_ExportService())

            ->csv(

                $rows,

                'teachers.csv'

            );

    }

    public function exportSubjects(): void {

        $rows =

            (new ESP_SubjectRepository())

            ->all();

        (new ESP_ExportService())

            ->csv(

                $rows,

                'subjects.csv'

            );

    }

}