<?php

defined('ABSPATH') || exit;

class ESP_PermissionService {

    public static function install(): void {

        if (

            $role = get_role(

                'administrator'

            )

        ) {

            foreach (

                self::capabilities()

                as

                $cap

            ) {

                $role->add_cap(

                    $cap

                );

            }

        }
        if ($role = get_role('teacher')) {
            foreach (['esp_teacher','esp_enter_marks'] as $cap) $role->add_cap($cap);
        }

    }

    public static function capabilities(): array {

        return [

            'esp_manage_sessions',

            'esp_manage_classes',

            'esp_manage_subjects',

            'esp_manage_students',

            'esp_manage_teachers',

            'esp_manage_exams',

            'esp_enter_marks',

            'esp_resubmit_marks',

            'esp_publish_results',

            'esp_view_reports'
            ,'esp_teacher'

        ];

    }

}
