<?php

defined('ABSPATH') || exit;

class ESP_Ajax_Marks {

    public static function register(): void {

        add_action(
            'wp_ajax_esp_save_marks',
            [self::class,'save']
        );

    }

    public static function save(): void {

        esp_verify_nonce();

        $service=ESP_Container::make(
            ESP_MarksService::class
        );

        $rows = [];
        foreach ((array) ($_POST['data'] ?? []) as $row) {
            $rows[] = [
                'exam_id' => absint($_POST['exam_id'] ?? 0),
                'student_id' => absint($row['student_id'] ?? 0),
                'subject_id' => absint($row['subject_id'] ?? 0),
                'obtained_marks' => (float) ($row['obtained_marks'] ?? 0),
            ];
        }

        wp_send_json_success(

            [

                'saved'=>$service->save($rows)

            ]

        );

    }

}
