<?php

defined('ABSPATH') || exit;

class ESP_AcademicSessionService implements ESP_ServiceInterface {

    protected ESP_SessionRepository $repository;

    public function __construct() {

        $this->repository =

            ESP_Container::make(

                ESP_SessionRepository::class

            );

    }

    public function all(): array {

        return

            $this->repository->all();

    }

    public function find(

        int $id

    ) {

        return

            $this->repository->find($id);

    }

    public function save(

        array $data

    ): bool {

        if (

            empty($data['id'])

        ) {

            return (bool)

                $this->repository->insert($data);

        }

        return

            $this->repository->update(

                (int)$data['id'],

                $data

            );

    }

    public function delete(

        int $id

    ): bool {

        return

            $this->repository->delete($id);

    }

}