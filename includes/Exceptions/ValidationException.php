<?php

defined('ABSPATH') || exit;

class ESP_ValidationException extends ESP_Exception {

    protected array $errors = [];

    public function __construct(

        array $errors

    ) {

        parent::__construct(

            'Validation failed.'

        );

        $this->errors =

            $errors;

    }

    public function errors(): array {

        return

            $this->errors;

    }

}