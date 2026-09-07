<?php

defined('ABSPATH') || exit;

trait ESP_SingletonTrait {

    private static $instance;

    public static function instance() {

        if (

            !isset(

                self::$instance

            )

        ) {

            self::$instance =

                new static();

        }

        return

            self::$instance;

    }

}