<?php

defined('ABSPATH') || exit;

class ESP_AdminMenu {

    public static function register(): void {

        add_action(

            'admin_menu',

            [

                self::class,

                'menus'

            ]

        );

    }

    public static function menus(): void {
        if (!current_user_can('manage_options') && current_user_can('esp_teacher')) {
            add_menu_page(__('Exam System','exam-system-pro'), __('Exam System','exam-system-pro'), 'esp_teacher', 'esp-marks', [ESP_AdminMarksPage::class,'render'], 'dashicons-welcome-learn-more', 26);
            return;
        }

        add_menu_page(

            __('Exam System','exam-system-pro'),

            __('Exam System','exam-system-pro'),

            'manage_options',

            'exam-system-pro',

            [

                ESP_AdminDashboardPage::class,

                'render'

            ],

            'dashicons-welcome-learn-more',

            26

        );

        self::submenus();

    }

    protected static function submenus(): void {

        self::page(

            'Dashboard',

            'exam-system-pro',

            ESP_AdminDashboardPage::class

        );

        self::page(

            'Academic Sessions',

            'esp-sessions',

            ESP_AdminSessionPage::class

        );

        if (ESP_CampusContext::can_manage_registry()) {
            self::page(
                'Campuses',
                'esp-campuses',
                ESP_AdminCampusPage::class
            );
        }

        self::page(

            'Classes',

            'esp-classes',

            ESP_AdminClassPage::class

        );

        self::page(

            'Subjects',

            'esp-subjects',

            ESP_AdminSubjectPage::class

        );

        self::page(

            'Teachers',

            'esp-teachers',

            ESP_AdminTeacherPage::class

        );

        self::page(

            'Students',

            'esp-students',

            ESP_AdminStudentPage::class

        );

        self::page(
            'Subject Allocation',
            'esp-allocations',
            ESP_AdminAllocationPage::class
        );

        self::page(

            'Exams',

            'esp-exams',

            ESP_AdminExamPage::class

        );

        self::page(

            'Exam Schedules',

            'esp-exam-schedules',

            ESP_AdminExamSchedulePage::class

        );

        self::page(

            'Marks Entry',

            'esp-marks',

            ESP_AdminMarksPage::class

        );

        self::page(

            'Results',

            'esp-results',

            ESP_AdminResultPage::class

        );

        self::page(

            'Reports',

            'esp-reports',

            ESP_AdminReportPage::class

        );

        self::page(
            'Promotion',
            'esp-promotion',
            ESP_AdminPromotionPage::class
        );

        self::page(

            'Settings',

            'esp-settings',

            ESP_AdminSettingsPage::class

        );

    }

    protected static function page(

        string $title,

        string $slug,

        string $class

    ): void {

        add_submenu_page(

            'exam-system-pro',

            $title,

            $title,

            'manage_options',

            $slug,

            [

                $class,

                'render'

            ]

        );

    }

}
