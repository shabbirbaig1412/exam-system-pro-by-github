<?php

defined('ABSPATH') || exit;

class ESP_ResultDTO {

    public int $student_id = 0;

    public float $total = 0;

    public float $obtained = 0;

    public float $percentage = 0;

    public string $grade = '';

    public string $status = '';

    use ESP_ArrayableTrait;

    use ESP_FillableTrait;

}