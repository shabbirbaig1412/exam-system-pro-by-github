<?php

defined('ABSPATH') || exit;

interface ESP_RepositoryInterface {

    public function all(): array;

    public function find(int $id);

    public function insert(array $data): int;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

}