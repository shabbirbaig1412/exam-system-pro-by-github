<?php

defined('ABSPATH') || exit;

class ESP_MarksDTO {

    public int $student_id = 0;

    public int $subject_id = 0;

    public float $obtained = 0;

    public float $total = 0;

    public string $remarks = '';

    use ESP_ArrayableTrait;

    use ESP_FillableTrait;

}