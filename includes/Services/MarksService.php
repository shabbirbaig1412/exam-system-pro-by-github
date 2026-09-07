<?php

defined('ABSPATH') || exit;

class ESP_MarksService implements ESP_ServiceInterface {

    protected ESP_MarksRepository $repository;

    public function __construct() {

        $this->repository =
            ESP_Container::make(
                ESP_MarksRepository::class
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

        $saved = $this->repository->saveMarks(
            $data
        );

        if ($saved) {

            $exam_id = (int) ($data[0]['exam_id'] ?? 0);

            if ($exam_id) {
                ESP_MarksSubmitted::dispatch(
                    $exam_id,
                    get_current_user_id()
                );
            }

        }

        return $saved;

    }

    public function delete(
        int $id
    ): bool {

        return $this->repository->delete($id);

    }

}
