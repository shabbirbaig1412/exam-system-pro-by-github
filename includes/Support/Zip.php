<?php

defined('ABSPATH') || exit;

class ESP_Zip {

    public static function create(

        string $zipFile,

        array $files

    ): bool {

        $zip = new ZipArchive();

        if (

            $zip->open(

                $zipFile,

                ZipArchive::CREATE

            ) !== true

        ) {

            return false;

        }

        foreach (

            $files as $file

        ) {

            if (

                file_exists($file)

            ) {

                $zip->addFile(

                    $file,

                    basename($file)

                );

            }

        }

        $zip->close();

        return true;

    }

}