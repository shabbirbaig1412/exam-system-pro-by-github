<?php

defined('ABSPATH') || exit;

class ESP_ActivityLogService {

    protected ESP_ActivityRepository $repository;

    public function __construct() {

        $this->repository =

            ESP_Container::make(

                ESP_ActivityRepository::class

            );

    }

    public function log(

        string $action,

        string $description,

        int $userId=0

    ): void {

        $this->repository->insert(

            [

                'user_id'     => $userId ?: get_current_user_id(),

                'action'      => $action,

                'description' => $description,

                'created_at'  => current_time('mysql')

            ]

        );

    }

}