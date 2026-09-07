<?php

defined('ABSPATH') || exit;

class ESP_TopperCalculator {

    public static function first(

        array $students

    ): array {

        usort(

            $students,

            fn($a,$b)=>$b['obtained']<=>$a['obtained']

        );

        return $students[0] ?? [];

    }

}