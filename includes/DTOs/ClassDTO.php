<?php

defined('ABSPATH') || exit;

class ESP_ClassDTO {

    public int $id = 0;

    public string $name = '';

    public int $sort_order = 0;

    public int $status = 1;

    use ESP_ArrayableTrait;

    use ESP_FillableTrait;

}