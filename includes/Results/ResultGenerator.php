<?php

defined('ABSPATH') || exit;

class ESP_ResultGenerator {

    public function generate(

        array $student

    ): array {

        $percentage =

            ESP_PercentageCalculator::calculate(

                $student['obtained'],

                $student['total']

            );

        return [

            'obtained'=>$student['obtained'],

            'total'=>$student['total'],

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