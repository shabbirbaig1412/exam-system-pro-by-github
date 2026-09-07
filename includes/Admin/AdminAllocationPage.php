<?php

defined('ABSPATH') || exit;

class ESP_AdminAllocationPage {

    public static function render(): void {

        ESP_Capability::admin();

        $controller = new ESP_AllocationController();
        $controller->index();
    }
}
