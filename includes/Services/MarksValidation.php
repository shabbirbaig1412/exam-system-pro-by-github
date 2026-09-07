<?php

defined('ABSPATH') || exit;

class ESP_MarksValidation {

    public static function validate(

        float $marks,

        float $total

    ): bool {

        if ($marks < 0) {

            return false;

        }

        if ($marks > $total) {

            return false;

        }

        return true;

    }

}