<?php

defined('ABSPATH') || exit;

class ESP_DivisionCalculator {

    public static function calculate(

        float $percentage

    ): string {

        if($percentage>=60){

            return 'First';

        }

        if($percentage>=45){

            return 'Second';

        }

        if($percentage>=33){

            return 'Third';

        }

        return 'Fail';

    }

}