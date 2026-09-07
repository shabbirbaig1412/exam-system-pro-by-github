<?php

defined('ABSPATH') || exit;

class ESP_ExcelEngine {

    public function export(string $filename, array $rows): void {

        if (headers_sent()) {
            return;
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        $fp = fopen('php://output', 'w');

        if (!empty($rows)) {

            fputcsv($fp, array_keys((array)$rows[0]));

            foreach ($rows as $row) {

                fputcsv($fp, (array)$row);

            }

        }

        fclose($fp);

        exit;

    }

}