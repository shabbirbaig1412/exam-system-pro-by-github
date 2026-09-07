<?php

defined('ABSPATH') || exit;

class ESP_Result {

    public int $id = 0;

    public int $exam_id = 0;

    public int $student_id = 0;

    public float $total_marks = 0;

    public float $obtained_marks = 0;

    public float $percentage = 0;

    public string $grade = '';

    public string $remarks = '';

    public string $status = '';

    public int $position = 0;

}