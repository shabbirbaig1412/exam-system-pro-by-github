<?php

defined('ABSPATH') || exit;

class ESP_Statistics {

    public static function passRate(

        int $exam_id

    ): float {

        $summary =

            ESP_StatisticsEngine

            ::classSummary(

                $exam_id

            );

        if (

            empty(

                $summary['students']

            )

        ) {

            return 0;

        }

        return round(

            (

                $summary['passed']

                /

                $summary['students']

            ) * 100,

            2

        );

    }

    public static function failRate(

        int $exam_id

    ): float {

        $summary =

            ESP_StatisticsEngine

            ::classSummary(

                $exam_id

            );

        if (

            empty(

                $summary['students']

            )

        ) {

            return 0;

        }

        return round(

            (

                $summary['failed']

                /

                $summary['students']

            ) * 100,

            2

        );

    }

}