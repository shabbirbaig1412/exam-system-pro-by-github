<?php

defined('ABSPATH') || exit;

class ESP_ControllerFactory {

    public static function make(

        string $controller

    ) {

        return new $controller();

    }

}