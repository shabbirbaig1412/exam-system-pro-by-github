<?php

defined('ABSPATH') || exit;

class ESP_SubjectResultCalculator {

    public function calculate(

        float $obtained,

        float $total

    ): array {

        $percentage =

            ESP_PercentageCalculator::calculate(

                $obtained,

                $total

            );

        return [

            'percentage'=>$percentage,

            'grade'=>ESP_GradeCalculator::grade(

                $percentage

            ),

            'status'=>ESP_PassFailCalculator::status(

                $percentage

            )

        ];

    }

}