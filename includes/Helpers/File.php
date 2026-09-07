<?php

defined('ABSPATH') || exit;

class ESP_File {

    public static function exists(

        string $file

    ): bool {

        return file_exists(

            $file

        );

    }

    public static function delete(

        string $file

    ): bool {

        if (

            self::exists($file)

        ) {

            return unlink($file);

        }

        return false;

    }

    public static function put(string $file, string $content): bool {

        return file_put_contents($file, $content) !== false;

    }

}
