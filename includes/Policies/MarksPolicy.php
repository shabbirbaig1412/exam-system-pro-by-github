<?php

defined('ABSPATH') || exit;

class ESP_MarksPolicy extends ESP_BasePolicy {

    public function submit(): bool {

        return $this->allow(

            'esp_enter_marks'

        );

    }

    public function resubmit(): bool {

        return $this->allow(

            'esp_resubmit_marks'

        );

    }

}