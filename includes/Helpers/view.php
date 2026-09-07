<?php

defined('ABSPATH') || exit;

function esp_view(

    string $view,

    array $data=[]

): void {

    ESP_View::render(

        $view,

        $data

    );

}