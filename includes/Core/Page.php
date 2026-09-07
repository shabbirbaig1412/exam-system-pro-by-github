<?php

defined('ABSPATH') || exit;

abstract class ESP_Page {

    abstract public function render(): void;

}