<?php

defined('ABSPATH') || exit;

trait ESP_TimestampTrait {

    protected function now(): string {

        return current_time(

            'mysql'

        );

    }

}