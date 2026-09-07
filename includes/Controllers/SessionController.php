<?php

defined('ABSPATH') || exit;

class ESP_SessionController {

    private ESP_SessionRepository $repo;

    public function __construct() {

        $this->repo = new ESP_SessionRepository();

    }

    public function index(): void {

        ESP_Capability::admin();

        $sessions = $this->repo->all();

        require ESP_TEMPLATE.'admin/sessions.php';

    }

}