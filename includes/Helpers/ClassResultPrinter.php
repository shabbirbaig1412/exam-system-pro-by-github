<?php

defined('ABSPATH') || exit;

class ESP_ClassResultPrinter {

    public function print(

        int $exam_id

    ): void {

        $results =

            (new ESP_ResultRepository())

            ->examResults(

                $exam_id

            );

        require

        ESP_TEMPLATE

        .'print/class-result.php';

    }

}