<?php

defined('ABSPATH') || exit;

class ESP_ExamScheduleService implements ESP_ServiceInterface {

    protected ESP_ExamScheduleRepository $repository;

    public function __construct() {

        $this->repository = ESP_Container::make(

            ESP_ExamScheduleRepository::class

        );

    }

    public function all(): array {

        return $this->repository->all();

    }

    public function find(int $id) {

        return $this->repository->find($id);

    }

    public function findByExam(int $exam_id): array {

        return $this->repository->findByExam($exam_id);

    }

    public function findByClass(int $class_id): array {

        return $this->repository->findByClass($class_id);

    }

    public function save(array $data): bool {

        return (bool) $this->repository->insert($data);

    }

    public function delete(int $id): bool {

        return $this->repository->delete($id);

    }

    public function getSubjectsForSchedule(int $schedule_id): array {

        return $this->repository->getSubjectsForSchedule($schedule_id);

    }

}
