<?php

defined('ABSPATH') || exit;

class ESP_CSVExporter {

    public function download(

        array $rows,

        string $filename

    ): void {

        header(

            'Content-Type:text/csv'

        );

        header(

            'Content-Disposition:attachment; filename='.$filename

        );

        $fp=fopen('php://output','w');

        foreach($rows as $row){

            fputcsv($fp,$row);

        }

        fclose($fp);

        exit;

    }

}