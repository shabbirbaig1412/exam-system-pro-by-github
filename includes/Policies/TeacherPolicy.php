<?php

defined('ABSPATH') || exit;

class ESP_TeacherPolicy extends ESP_BasePolicy {

    public function create(): bool {

        return $this->allow(

            'esp_manage_teachers'

        );

    }

    public function update(): bool {

        return $this->allow(

            'esp_manage_teachers'

        );

    }

    public function delete(): bool {

        return $this->allow(

            'esp_manage_teachers'

        );

    }

}