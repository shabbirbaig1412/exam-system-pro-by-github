<?php

defined('ABSPATH') || exit;

class ESP_ExamSchedule {

    public int $id = 0;

    public int $campus_id = 0;

    public int $exam_id = 0;

    public int $class_id = 0;

    public string $exam_date = '';

    public string $start_time = '';

    public string $end_time = '';

    public string $remarks = '';

    public int $status = 1;

    public string $created_at = '';

    public string $updated_at = '';

}
