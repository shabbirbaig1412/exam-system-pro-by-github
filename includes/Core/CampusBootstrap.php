<?php

defined('ABSPATH') || exit;

class ESP_CampusBootstrap {

    public static function init(): void{

        if(

            isset($_GET['campus'])

        ){

            ESP_CampusContext::set(

                absint(

                    $_GET['campus']

                )

            );

        }

    }

}