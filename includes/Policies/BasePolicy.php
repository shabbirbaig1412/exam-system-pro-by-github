<?php

defined('ABSPATH') || exit;

abstract class ESP_BasePolicy {

    protected function allow(

        string $capability

    ): bool {

        return current_user_can(

            $capability

        );

    }

}