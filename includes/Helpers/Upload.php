<?php

defined('ABSPATH') || exit;

class ESP_Upload {

    public static function file(

        string $field,

        string $directory='imports'

    ): array {

        if (empty($_FILES[$field]['name'])) {

            throw new ESP_ImportException('No file was uploaded.');

        }

        require_once ABSPATH.'wp-admin/includes/file.php';

        $upload = wp_handle_upload($_FILES[$field], ['test_form' => false]);

        if (isset($upload['error'])) {

            throw new ESP_ImportException($upload['error']);

        }

        return $upload;

    }

    public static function csv(

        string $field

    ): ?string {

        if (

            empty($_FILES[$field]['name'])

        ) {

            return null;

        }

        try {

            return self::file($field)['file'];

        } catch (ESP_ImportException $exception) {

            return null;

        }

    }

}
