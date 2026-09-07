<?php

defined('ABSPATH') || exit;

class ESP_ClassResultPdf {

    public function download(int $exam_id): void {

        ob_start();

        (new ESP_ClassResult())->render($exam_id);

        $html = ob_get_clean();

        (new ESP_PdfEngine())->output(

            'Class Result',

            $html

        );

    }

}