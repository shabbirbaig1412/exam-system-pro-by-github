<?php

defined('ABSPATH') || exit;

class ESP_NotificationService {

    public function email(string $to, string $subject, string $message): bool {

        return wp_mail($to, $subject, $message);

    }

    public function admin(string $message): void {

        add_settings_error('esp', 'esp', $message, 'updated');

    }

    public function success(

        string $message

    ): void {

        ESP_Flash::success(

            $message

        );

    }

    public function error(

        string $message

    ): void {

        ESP_Flash::error(

            $message

        );

    }

    public function info(

        string $message

    ): void {

        ESP_Flash::info(

            $message

        );

    }

}
