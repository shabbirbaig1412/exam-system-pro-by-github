<?php

defined('ABSPATH') || exit;

interface ESP_ExportInterface {

    public function export(

        array $data,

        string $filename

    ): void;

}