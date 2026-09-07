<?php

defined('ABSPATH') || exit;

class ESP_Search {

    public static function keyword(): string {

        return isset(

            $_GET['s']

        )

        ?

        sanitize_text_field(

            $_GET['s']

        )

        :

        '';

    }

}