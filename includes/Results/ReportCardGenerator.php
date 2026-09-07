<?php

defined('ABSPATH') || exit;

class ESP_ReportCardGenerator {

    public function build(

        array $student

    ): array {

        return

            (new ESP_ResultGenerator())

            ->generate($student);

    }

}