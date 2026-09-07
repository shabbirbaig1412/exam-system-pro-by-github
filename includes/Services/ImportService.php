<?php

defined('ABSPATH') || exit;

class ESP_ImportService {

    protected ESP_ImportRepository $repository;

    public function __construct() {

        $this->repository =

            ESP_Container::make(

                ESP_ImportRepository::class

            );

    }

    public function students(

        string $file

    ): bool {

        return $this->repository->students(

            $file

        );

    }

    public function marks(

        string $file

    ): bool {

        return $this->repository->marks(

            $file

        );

    }

}