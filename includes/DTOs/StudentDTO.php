<?php

defined('ABSPATH') || exit;

class ESP_StudentDTO {

    public int $id = 0;

    public int $class_id = 0;

    public string $roll_no = '';

    public string $name = '';

    public int $status = 1;

    use ESP_ArrayableTrait;

    use ESP_FillableTrait;

}