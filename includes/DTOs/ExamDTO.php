<?php

defined('ABSPATH') || exit;

class ESP_ExamDTO {

    public int $id = 0;

    public int $session_id = 0;

    public string $title = '';

    public string $exam_date = '';

    public int $status = 1;

    use ESP_ArrayableTrait;

    use ESP_FillableTrait;

}