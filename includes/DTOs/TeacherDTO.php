<?php

defined('ABSPATH') || exit;

class ESP_TeacherDTO {

    public int $id = 0;

    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public int $status = 1;

    use ESP_ArrayableTrait;

    use ESP_FillableTrait;

}