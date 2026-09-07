<?php

defined('ABSPATH') || exit;

class ESP_TranscriptGenerator {

    public function generate(

        array $student

    ): array {

        $student['cgpa']=

            ESP_CGPACalculator::calculate(

                $student['subjects']

            );

        return $student;

    }

}