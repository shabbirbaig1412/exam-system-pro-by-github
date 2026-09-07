<?php

defined('ABSPATH') || exit;

trait ESP_FillableTrait {

    public function fill(

        array $attributes

    ): self {

        foreach (

            $attributes

            as

            $key => $value

        ) {

            if (

                property_exists(

                    $this,

                    $key

                )

            ) {

                $this->$key =

                    $value;

            }

        }

        return $this;

    }

}