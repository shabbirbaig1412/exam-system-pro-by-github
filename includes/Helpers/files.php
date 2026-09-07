<?php

defined('ABSPATH') || exit;

function esp_upload_dir(): string {

    $upload = wp_upload_dir();

    return

        trailingslashit(

            $upload['basedir']

        )

        .

        'exam-system';

}

function esp_create_directory(): void {

    wp_mkdir_p(

        esp_upload_dir()

    );

}