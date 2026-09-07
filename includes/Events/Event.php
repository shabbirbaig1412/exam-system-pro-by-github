<?php

defined('ABSPATH') || exit;

class ESP_Event {

    public static function dispatch(

        string $event,

        ...$payload

    ): void {

        do_action(

            'esp_'.$event,

            ...$payload

        );

    }

}