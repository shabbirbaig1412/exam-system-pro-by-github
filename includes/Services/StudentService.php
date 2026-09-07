<?php

defined('ABSPATH') || exit;

class ESP_StudentService implements ESP_ServiceInterface {

    protected ESP_StudentRepository $repository;

    public function __construct() {

        $this->repository =
            ESP_Container::make(
                ESP_StudentRepository::class
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

        if (empty($data['id'])) {

            $data['campus_id'] = ESP_CampusContext::id();

            $id = $this->repository->insert($data);

            if ($id) {

                ESP_StudentCreated::dispatch($id);

            }

            return (bool) $id;

        }

        return $this->repository->update(
            (int) $data['id'],
            $data
        );

    }

    public function delete(
        int $id
    ): bool {

        return $this->repository->delete($id);

    }

}
