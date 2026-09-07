<?php

defined('ABSPATH') || exit;

class ESP_ResultService implements ESP_ServiceInterface {

    protected ESP_ResultRepository $repository;

    public function __construct() {

        $this->repository =
            ESP_Container::make(
                ESP_ResultRepository::class
            );

    }

    public function all(): array {

        return $this->repository->all();

    }

    public function find(
        int $id
    ) {

        return $this->repository->find($id);

    }

    public function save(
        array $data
    ): bool {

        return (bool)
            $this->repository->insert(
                $data
            );

    }

    public function delete(
        int $id
    ): bool {

        return $this->repository->delete($id);

    }

    public function publish(
        int $examId
    ): bool {

        $status =
            $this->repository->publish(
                $examId
            );

        if ($status) {

            ESP_ResultPublished::dispatch(
                $examId
            );

        }

        return $status;

    }

}