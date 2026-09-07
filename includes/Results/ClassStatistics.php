<?php

defined('ABSPATH') || exit;

class ESP_ClassStatistics {

    public static function build(

        array $students

    ): array {

        $pass=0;

        foreach($students as $student){

            if($student['status']=='PASS'){

                $pass++;

            }

        }

        return [

            'students'=>count($students),

            'pass'=>$pass,

            'fail'=>count($students)-$pass,

            'pass_percentage'=>count($students)

                ? round(($pass/count($students))*100,2)

                :0

        ];

    }

}