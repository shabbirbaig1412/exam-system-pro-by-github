<?php

defined('ABSPATH') || exit;

class ESP_ValidationService {

    public function required(

        array $data,

        array $fields

    ): void {

        $errors = [];

        foreach (

            $fields as $field

        ) {

            if (

                empty(

                    $data[$field]

                )

            ) {

                $errors[$field] =

                    ucfirst($field)

                    .' is required';

            }

        }

        if (

            !empty($errors)

        ) {

            throw new ESP_ValidationException(

                $errors

            );

        }

    }

}