<?php

defined('ABSPATH') || exit;

class ESP_CGPACalculator {

    public static function calculate(

        array $subjects

    ): float {

        $points = 0;

        $credits = 0;

        foreach($subjects as $subject){

            $points +=

                $subject['grade_point']

                *

                $subject['credit'];

            $credits +=

                $subject['credit'];

        }

        if($credits==0){

            return 0;

        }

        return round(

            $points/$credits,

            2

        );

    }

}