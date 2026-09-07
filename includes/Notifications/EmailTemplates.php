<?php

defined('ABSPATH') || exit;

class ESP_EmailTemplates {

    public static function resultPublished(

        string $student

    ): string {

        return

        "Dear {$student},

Your examination result has been published.

Thank you.";

    }

}