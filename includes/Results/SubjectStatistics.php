<?php

defined('ABSPATH') || exit;

class ESP_SubjectStatistics {

    public static function build(

        array $marks

    ): array {

        if(empty($marks)){

            return [];

        }

        return [

            'highest'=>max($marks),

            'lowest'=>min($marks),

            'average'=>round(

                array_sum($marks)/count($marks),

                2

            )

        ];

    }

}