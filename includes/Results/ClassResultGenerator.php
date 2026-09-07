<?php

defined('ABSPATH') || exit;

class ESP_ClassResultGenerator {

    public function generate(

        array $students

    ): array {

        $gazette =

            new ESP_GazetteGenerator();

        return $gazette->build(

            $students

        );

    }

}