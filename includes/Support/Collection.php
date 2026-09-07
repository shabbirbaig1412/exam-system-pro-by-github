<?php

defined('ABSPATH') || exit;

class ESP_SupportCollection extends ESP_Collection {

    public function map(

        callable $callback

    ): self {

        return new self(

            array_map(

                $callback,

                $this->all()

            )

        );

    }

    public function filter(

        callable $callback

    ): self {

        return new self(

            array_filter(

                $this->all(),

                $callback

            )

        );

    }

}