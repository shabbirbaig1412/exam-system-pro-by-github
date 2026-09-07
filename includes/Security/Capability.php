<?php

defined('ABSPATH') || exit;

class ESP_Capability {

    public static function admin(): void {

        if (

            !current_user_can(

                'manage_options'

            )

        ) {

            wp_die(

                esc_html__(

                    'Permission denied.',

                    'exam-system-pro'

                )

            );

        }

    }

    public static function teacher(): void {
        if (esp_can_manage() || esp_is_teacher()) {
            return;
        }

        wp_die(
            esc_html__(
                'Permission denied.',
                'exam-system-pro'
            )
        );
    }

}