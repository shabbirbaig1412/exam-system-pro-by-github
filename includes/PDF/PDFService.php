<?php

defined('ABSPATH') || exit;

class ESP_PDFService {

    protected ESP_PDF_Adapter $adapter;

    public function __construct() {

        $this->adapter = new ESP_PDF_Adapter();

    }

    public function download(
        string $html,
        string $filename
    ): void {

        $this->adapter
            ->render($html)
            ->download($filename);

    }

    public function stream(
        string $html,
        string $filename
    ): void {

        $this->adapter
            ->render($html)
            ->stream($filename);

    }

}