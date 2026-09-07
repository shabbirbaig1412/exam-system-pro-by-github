<?php

defined('ABSPATH') || exit;

function esp_admin_url(

    string $page

): string {

    return admin_url(

        'admin.php?page=' .

        $page

    );

}

function esp_asset(

    string $path

): string {

    return ESP_URL .

        ltrim(

            $path,

            '/'

        );

}