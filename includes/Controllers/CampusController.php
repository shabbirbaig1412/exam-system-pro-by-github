<?php

defined('ABSPATH') || exit;

class ESP_CampusController {

    protected ESP_CampusService $service;

    public function __construct(

        ESP_CampusService $service

    ){

        $this->service=$service;

    }

    public function index(): void{

        ESP_View::render(

            'admin/campuses',

            [

                'campuses'=>$this->service->campuses()

            ]

        );

    }

}