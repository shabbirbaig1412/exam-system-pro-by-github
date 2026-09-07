<?php

defined('ABSPATH') || exit;

class ESP_ResultPublished {

    public static function dispatch(

        int $examId

    ): void {

        ESP_Event::dispatch(

            'result_published',

            $examId

        );

    }

}