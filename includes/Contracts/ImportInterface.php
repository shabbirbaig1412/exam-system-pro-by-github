<?php

defined('ABSPATH') || exit;

interface ESP_ImportInterface {

    public function import(

        string $file

    ): bool;

}