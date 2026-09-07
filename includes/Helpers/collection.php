<?php

defined('ABSPATH') || exit;

function esp_collect(

    array $items=[]

): ESP_Collection {

    return new ESP_Collection(

        $items

    );

}