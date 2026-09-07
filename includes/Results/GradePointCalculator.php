<?php

defined('ABSPATH') || exit;

class ESP_GradePointCalculator {

    protected static array $points=[

        'A+'=>4.00,

        'A'=>3.70,

        'B'=>3.00,

        'C'=>2.00,

        'D'=>1.00,

        'E'=>0.50,

        'F'=>0.00

    ];

    public static function point(

        string $grade

    ): float {

        return self::$points[$grade] ?? 0;

    }

}