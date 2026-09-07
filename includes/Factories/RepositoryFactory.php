<?php

defined('ABSPATH') || exit;

class ESP_RepositoryFactory {

    public static function make(

        string $repository

    ): ESP_BaseRepository {

        return ESP_Container::make(

            $repository

        );

    }

}