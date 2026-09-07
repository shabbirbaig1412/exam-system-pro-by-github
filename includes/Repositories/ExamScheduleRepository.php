<?php

defined('ABSPATH') || exit;

class ESP_ExamScheduleRepository extends ESP_CampusAwareRepository {

    protected string $table = 'esp_exam_schedules';

    public function all(): array {

        global $wpdb;

        return $wpdb->get_results(

            $wpdb->prepare(

                "SELECT * FROM {$this->table}

                WHERE campus_id=%d 

                ORDER BY exam_date DESC, created_at DESC",

                ESP_CampusContext::id()

            ),

            ARRAY_A

        );

    }

    public function findByExam(int $exam_id): array {

        global $wpdb;

        return $wpdb->get_results(

            $wpdb->prepare(

                "SELECT * FROM {$this->table}

                WHERE exam_id=%d AND campus_id=%d 

                ORDER BY exam_date ASC",

                $exam_id,

                ESP_CampusContext::id()

            ),

            ARRAY_A

        );

    }

    public function findByClass(int $class_id): array {

        global $wpdb;

        return $wpdb->get_results(

            $wpdb->prepare(

                "SELECT * FROM {$this->table}

                WHERE class_id=%d AND campus_id=%d 

                ORDER BY exam_date ASC",

                $class_id,

                ESP_CampusContext::id()

            ),

            ARRAY_A

        );

    }

    public function getSubjectsForSchedule(int $schedule_id): array {

        global $wpdb;

        $schedule = $this->find($schedule_id);

        if (!$schedule) {

            return [];

        }

        return $wpdb->get_results(

            $wpdb->prepare(

                "SELECT DISTINCT s.* FROM {$wpdb->prefix}esp_subjects s

                INNER JOIN {$wpdb->prefix}esp_allocations a 

                    ON a.subject_id=s.id AND a.campus_id=s.campus_id

                WHERE a.class_id=%d AND s.campus_id=%d 

                ORDER BY s.subject_name",

                $schedule['class_id'],

                ESP_CampusContext::id()

            ),

            ARRAY_A

        );

    }

}
