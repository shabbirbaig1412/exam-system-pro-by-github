<?php

defined('ABSPATH') || exit;

class ESP_AllocationService {

    private ESP_AllocationRepository $repo;

    public function __construct() {

        $this->repo =

            new ESP_AllocationRepository();

    }

    public function all(): array {

        return

            $this->repo->all();

    }

    public function save(

        array $data

    ): bool {

        $data['campus_id'] = ESP_CampusContext::id();

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
