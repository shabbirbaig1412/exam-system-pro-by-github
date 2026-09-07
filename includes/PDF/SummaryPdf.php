<?php

defined('ABSPATH') || exit;

class ESP_SummaryPdf {

    public function download(int $exam_id): void {

        ob_start();

        (new ESP_ClassSummary())->render($exam_id);

        $html = ob_get_clean();

        (new ESP_PdfEngine())->output(

            'Class Summary',

            $html

        );

    }

}