<?php

defined('ABSPATH') || exit;

trait ESP_JsonTrait {

    public function toJson(): string {

        return wp_json_encode(

            get_object_vars(

                $this

            )

        );

    }

}