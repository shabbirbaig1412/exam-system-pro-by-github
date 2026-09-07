<?php

defined('ABSPATH') || exit;

class ESP_PassListGenerator {

    public static function build(

        array $students

    ): array {

        return array_values(

            array_filter(

                $students,

                fn($s)=>$s['status']=='PASS'

            )

        );

    }

}