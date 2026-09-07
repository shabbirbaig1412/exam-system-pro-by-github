<?php

defined('ABSPATH') || exit;

class ESP_ReportController {

    protected ESP_ReportService $service;

    public function __construct() {

        $this->service =
            ESP_Container::make(
                ESP_ReportService::class
            );

    }

    public function classSummary(
        int $examId
    ): array {

        return $this->service
            ->classSummary(
                $examId
            );

    }

    public function teacherSummary(
        int $examId
    ): array {

        return $this->service
            ->teacherSummary(
                $examId
            );

    }

    public function gazette(
        int $examId
    ): array {

        return $this->service
            ->gazette(
                $examId
            );

    }

}