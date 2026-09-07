<?php

defined('ABSPATH') || exit;

class ESP_ExamPolicy extends ESP_BasePolicy {

    public function create(): bool {

        return $this->allow(

            'esp_manage_exams'

        );

    }

    public function publish(): bool {

        return $this->allow(

            'esp_publish_results'

        );

    }

    public function delete(): bool {

        return $this->allow(

            'esp_manage_exams'

        );

    }

}