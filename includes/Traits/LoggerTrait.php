<?php

defined('ABSPATH') || exit;

trait ESP_LoggerTrait {

    protected function log(

        string $message

    ): void {

        ESP_Logger::log(

            $message

        );

    }

}