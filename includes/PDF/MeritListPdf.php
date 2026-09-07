<?php

defined('ABSPATH') || exit;

class ESP_MeritListPdf {

    public function download(int $exam_id): void {

        ob_start();

        (new ESP_MeritList())->render($exam_id);

        $html = ob_get_clean();

        (new ESP_PdfEngine())->output(

            'Merit List',

            $html

        );

    }

}