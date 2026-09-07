<?php

defined('ABSPATH') || exit;

class ESP_PercentageCalculator {

    public static function calculate(

        float $obtained,

        float $total

    ): float {

        if($total<=0){

            return 0;

        }

        return round(

            ($obtained/$total)*100,

            2

        );

    }

}