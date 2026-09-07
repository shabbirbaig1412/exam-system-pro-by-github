<?php

defined('ABSPATH') || exit;

class ESP_ReportService {

    protected ESP_ReportRepository $repository;

    public function __construct() {

        $this->repository =
            ESP_Container::make(
                ESP_ReportRepository::class
            );

    }

    public function classSummary(
        int $examId
    ): array {

        return $this->repository
            ->classSummary($examId);

    }

    public function teacherSummary(
        int $examId
    ): array {

        return $this->repository
            ->teacherSummary($examId);

    }

    public function gazette(
        int $examId
    ): array {

        return $this->repository
            ->gazette($examId);

    }

}