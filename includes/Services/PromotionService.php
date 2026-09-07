<?php

defined('ABSPATH') || exit;

class ESP_PromotionService {

    protected ESP_StudentRepository $students;

    public function __construct() {

        $this->students =
            ESP_Container::make(
                ESP_StudentRepository::class
            );

    }

    public function promote(
        int $studentId,
        int $nextClass
    ): bool {

        global $wpdb;
        $campus = ESP_CampusContext::id();
        $session = ESP_SessionContext::id();
        $valid_student = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_students WHERE id=%d AND campus_id=%d AND session_id=%d",$studentId,$campus,$session));
        $valid_class = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_classes WHERE id=%d AND campus_id=%d",$nextClass,$campus));
        if (!$valid_student || !$valid_class) return false;
        return $this->students->update(

            $studentId,

            [

                'class_id' => $nextClass

            ]

        );

    }

}
