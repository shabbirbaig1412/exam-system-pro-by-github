<?php

defined('ABSPATH') || exit;

class ESP_Validator {

    private array $errors=[];

    public function required(

        string $field,

        $value,

        string $label

    ): self {

        if(

            trim((string)$value)===''

        ){

            $this->errors[$field]

            =

            "{$label} is required.";

        }

        return $this;

    }

    public function email(

        string $field,

        $value

    ): self {

        if(

            $value!=''

            &&

            !is_email($value)

        ){

            $this->errors[$field]

            =

            "Invalid email.";

        }

        return $this;

    }

    public function numeric(

        string $field,

        $value

    ): self {

        if(

            !is_numeric($value)

        ){

            $this->errors[$field]

            =

            "Invalid number.";

        }

        return $this;

    }

    public function passes(): bool {

        return empty(

            $this->errors

        );

    }

    public function errors(): array {

        return $this->errors;

    }

}