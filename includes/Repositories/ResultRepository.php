<?php

defined('ABSPATH') || exit;

class ESP_ResultRepository extends ESP_BaseRepository {

    protected string $table='esp_results';

    public function save(array $data): bool {

        global $wpdb;

        $data['campus_id'] = ESP_CampusContext::id();
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM {$this->table} WHERE exam_id=%d AND student_id=%d AND campus_id=%d",
            (int) $data['exam_id'],
            (int) $data['student_id'],
            (int) $data['campus_id']
        ));

        $data['updated_at'] = current_time('mysql');
        if (!$existing) {
            $data['created_at'] = $data['updated_at'];
            return (bool) $wpdb->insert($this->table, $data);
        }

        return $wpdb->update(
            $this->table,
            $data,
            ['id' => (int) $existing, 'campus_id' => (int) $data['campus_id']]
        ) !== false;
    }

    public function exam_results(int $exam_id): array {
        global $wpdb;
        $campus = ESP_CampusContext::id();

        return (array) $wpdb->get_results($wpdb->prepare(
            "SELECT r.*, 
                    s.student_name, s.roll_no, s.father_name,
                    e.exam_name, c.class_name, c.id as class_id
             FROM {$this->table} r
             INNER JOIN {$wpdb->prefix}esp_exams e ON e.id=r.exam_id AND e.campus_id=r.campus_id
             INNER JOIN {$wpdb->prefix}esp_students s ON s.id=r.student_id AND s.campus_id=r.campus_id
             INNER JOIN {$wpdb->prefix}esp_classes c ON c.id=s.class_id AND c.campus_id=s.campus_id
             WHERE r.exam_id=%d
             AND r.campus_id=%d
             ORDER BY r.position ASC, r.obtained_marks DESC, CAST(s.roll_no AS UNSIGNED) ASC, r.student_id ASC",
            $exam_id,
            $campus
        ));
    }

    public function publish(

        int $examId

    ): bool{

        global $wpdb;

        $exam_exists = $wpdb->get_var($wpdb->prepare("SELECT id FROM {$wpdb->prefix}esp_exams WHERE id=%d AND campus_id=%d",$examId,ESP_CampusContext::id()));
        if (!$exam_exists) return false;
        return (bool)$wpdb->update(

            $this->table,

            [

                'published'=>1,

                'published_at'=>current_time('mysql')

            ],

            [

                'exam_id'=>$examId,
                'campus_id'=>ESP_CampusContext::id()

            ]

        );

    }

}
