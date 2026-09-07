<?php

defined('ABSPATH') || exit;

class ESP_SessionService {

    private ESP_SessionRepository $repo;

    public function __construct() {

        $this->repo =

            new ESP_SessionRepository();

    }

    public function all(): array {

        return

            $this->repo->all();

    }

    public function active() {

        return

            $this->repo->active();

    }

    public function save(

        array $data

    ): bool {

        if (

            empty($data['id'])

        ) {

            return

                $this->repo->insert($data) > 0;

        }

        return

            $this->repo->update(

                (int)$data['id'],

                $data

            );

    }

    public function delete(

        int $id

    ): bool {

        return

            $this->repo->delete($id);

    }

}