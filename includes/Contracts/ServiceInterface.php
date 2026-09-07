<?php

defined('ABSPATH') || exit;

interface ESP_ServiceInterface {

    public function all(): array;

    public function save(array $data): bool;

    public function delete(int $id): bool;

}