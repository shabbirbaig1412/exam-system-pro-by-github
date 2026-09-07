<?php

defined('ABSPATH') || exit;

class ESP_Formatter {

    public static function percentage(

        float $obtained,

        float $total

    ): float {

        if(

            $total<=0

        ){

            return 0;

        }

        return round(

            ($obtained/$total)*100,

            ESP_Common::option(

                'result_decimals',

                2

            )

        );

    }

    public static function marks(

        float $marks

    ): string {

        return number_format(

            $marks,

            ESP_Common::option(

                'result_decimals',

                2

            )

        );

    }

}