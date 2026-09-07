<?php

defined('ABSPATH') || exit;

class ESP_StudentPolicy extends ESP_BasePolicy {

    public function create(): bool {

        return $this->allow(

            'esp_manage_students'

        );

    }

    public function update(): bool {

        return $this->allow(

            'esp_manage_students'

        );

    }

    public function delete(): bool {

        return $this->allow(

            'esp_manage_students'

        );

    }

}