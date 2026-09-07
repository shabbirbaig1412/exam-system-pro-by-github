<?php

defined('ABSPATH') || exit;

class ESP_ExportController {

    protected ESP_ExportService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_ExportService::class
            );

    }

    public function csv(
        array $rows,
        string $filename
    ): void {

        $this->service->csv(
            $rows,
            $filename
        );

    }

    public function excel(
        array $rows,
        string $filename
    ): void {

        $this->service->excel(
            $rows,
            $filename
        );

    }

    public function pdf(
        string $html,
        string $filename
    ): void {

        $this->service->pdf(
            $html,
            $filename
        );

    }

}