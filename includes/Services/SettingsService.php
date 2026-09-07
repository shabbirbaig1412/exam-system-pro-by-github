<?php

defined('ABSPATH') || exit;

class ESP_SettingsService {

    private ESP_SettingsRepository $repo;

    public function __construct() {

        $this->repo =

            new ESP_SettingsRepository();

    }

    public function all(): array {

        return

            $this->repo->all();

    }

    public function save(

        string $key,

        $value

    ): bool {

        return

            $this->repo->save(

                $key,

                $value

            );

    }

}