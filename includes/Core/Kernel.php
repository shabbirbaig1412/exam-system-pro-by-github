<?php

defined('ABSPATH') || exit;

class ESP_Kernel {

    public function boot(): void {

        ESP_Boot::run();

    }

}