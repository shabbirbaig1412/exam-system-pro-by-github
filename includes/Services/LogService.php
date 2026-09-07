<?php

defined('ABSPATH') || exit;

class ESP_LogService {

    public function write(

        string $action

    ): void {

        ESP_Logger::log(

            $action

        );

    }

    public function latest(

        int $limit=100

    ): array {

        return

            (new ESP_LogRepository())

            ->latest(

                $limit

            );

    }

}