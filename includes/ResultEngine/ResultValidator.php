<?php

defined('ABSPATH') || exit;

class ESP_ResultValidator {

    public function passed(

        array $subjects,

        float $overall_percentage,

        float $pass_percentage

    ): bool {

        foreach ($subjects as $subject) {

            if (

                $subject['obtained_marks']

                <

                $subject['passing_marks']

            ) {

                return false;

            }

        }

        return $overall_percentage >= $pass_percentage;

    }

}
