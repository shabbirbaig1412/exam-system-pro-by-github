<?php

defined('ABSPATH') || exit;

class ESP_CSV {

    public static function download(

        array $rows,

        string $filename

    ): void {

        header(

            'Content-Type:text/csv'

        );

        header(

            'Content-Disposition:attachment; filename="'.$filename.'"'

        );

        $fp = fopen(

            'php://output',

            'w'

        );

        if(

            !empty($rows)

        ){

            fputcsv(

                $fp,

                array_keys(

                    (array)$rows[0]

                )

            );

            foreach(

                $rows

                as

                $row

            ){

                fputcsv(

                    $fp,

                    (array)$row

                );

            }

        }

        fclose($fp);

        exit;

    }

}