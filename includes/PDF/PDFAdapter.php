<?php

defined('ABSPATH') || exit;

class ESP_PDF_Adapter {

    protected string $html='';

    public function render(
        string $html
    ): self {

        $this->html=$html;

        return $this;

    }

    public function download(
        string $filename
    ): void {

        // DOMPDF / TCPDF integration point.

    }

    public function stream(
        string $filename
    ): void {

        // Browser output.

    }

}