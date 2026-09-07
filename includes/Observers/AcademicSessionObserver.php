<?php

defined('ABSPATH') || exit;

class ESP_AcademicSessionObserver {

    public static function created(

        int $sessionId

    ): void {

        ESP_Logger::log(

            'Academic Session #'.$sessionId.

            ' created.'

        );

    }

    public static function updated(

        int $sessionId

    ): void {

        ESP_Logger::log(

            'Academic Session #'.$sessionId.

            ' updated.'

        );

    }

    public static function deleted(

        int $sessionId

    ): void {

        ESP_Logger::log(

            'Academic Session #'.$sessionId.

            ' deleted.'

        );

    }

}