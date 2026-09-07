<?php

defined('ABSPATH') || exit;

class ESP_PdfEngine {

    public function output(

        string $title,

        string $html

    ): void {

        echo "<html>";

        echo "<head>";

        echo "<title>{$title}</title>";

        echo "</head>";

        echo "<body>";

        echo $html;

        echo "</body>";

        echo "</html>";

    }

}