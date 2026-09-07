<?php

defined('ABSPATH') || exit;

class ESP_PassFailCalculator {

    public static function status(

        float $percentage

    ): string {

        $pass = (float)get_option(

            'esp_pass_percentage',

            40

        );

        return

            $percentage >= $pass

            ? 'PASS'

            : 'FAIL';

    }

}