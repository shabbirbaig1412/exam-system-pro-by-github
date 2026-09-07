<?php

defined('ABSPATH') || exit;

class ESP_CoreValidator {

    private array $errors=[];

    public function required(

        $value,

        string $field

    ): self {

        if(

            $value==='' ||

            $value===null

        ){

            $this->errors[] =

                $field.

                ' is required';

        }

        return $this;

    }

    public function email(

        $value,

        string $field

    ): self {

        if(

            !empty($value)

            &&

            !is_email($value)

        ){

            $this->errors[] =

                $field.

                ' is invalid';

        }

        return $this;

    }

    public function fails(): bool {

        return

            !empty(

                $this->errors

            );

    }

    public function errors(): array {

        return

            $this->errors;

    }

}