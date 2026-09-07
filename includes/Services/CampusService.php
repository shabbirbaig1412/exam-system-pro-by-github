<?php

defined('ABSPATH') || exit;

class ESP_CampusService {

    protected ESP_CampusRepository $repository;

    public function __construct(

        ESP_CampusRepository $repository

    ){

        $this->repository = $repository;

    }

    public function campuses(): array{

        return $this->repository->all();

    }

    public function campus(

        int $id

    ): ?array{

        return $this->repository->find($id);

    }

}