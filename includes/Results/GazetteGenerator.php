<?php

defined('ABSPATH') || exit;

class ESP_GazetteGenerator {

    public function build(

        array $students

    ): array {

        $generator =

            new ESP_ResultGenerator();

        foreach($students as &$student){

            $student=array_merge(

                $student,

                $generator->generate($student)

            );

        }

        return ESP_PositionCalculator::calculate(

            $students

        );

    }

}