<?php

defined('ABSPATH') || exit;

trait ESP_ArrayableTrait {

    public function toArray(): array {

        return get_object_vars(

            $this

        );

    }

}