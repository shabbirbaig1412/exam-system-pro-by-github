<?php

defined('ABSPATH') || exit;

interface ESP_ReportInterface {

    public function generate(

        int $examId

    ): array;

}