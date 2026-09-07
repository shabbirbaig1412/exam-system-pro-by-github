<?php

defined('ABSPATH') || exit;

class ESP_MarksRepository extends ESP_BaseRepository {

    protected string $table = 'esp_marks';

    public function loadSheet(
        int $exam,
        int $class,
        int $subject
    ): array {
        global $wpdb;
        $campus = ESP_CampusContext::id();
        $session = ESP_SessionContext::id();

        return (array) $wpdb->get_results(
            $wpdb->prepare(
                "SELECT st.id AS student_id, st.roll_no, st.student_name,
                        s.id AS subject_id, s.subject_name, s.total_marks, s.passing_marks,
                        m.obtained_marks AS obtained,
                        m.remarks, m.locked_at, m.submitted_at
                 FROM {$wpdb->prefix}esp_students st
                 INNER JOIN {$wpdb->prefix}esp_exam_schedules es ON es.exam_id=%d AND es.class_id=%d AND es.campus_id=%d AND es.status=1
                 INNER JOIN {$wpdb->prefix}esp_subjects s ON s.id=%d AND s.campus_id=es.campus_id
                 LEFT JOIN {$this->table} m ON m.exam_id=es.exam_id AND m.student_id=st.id AND m.subject_id=s.id AND m.campus_id=es.campus_id
                 WHERE st.class_id=%d
                 AND st.session_id=%d
                 AND st.campus_id=es.campus_id
                 AND st.status=1
                 ORDER BY CAST(st.roll_no AS UNSIGNED) ASC, st.roll_no ASC, st.student_name ASC",
                $exam,
                $class,
                $campus,
                $subject,
                $class,
                $session
            ),
            ARRAY_A
        );
    }

    public function saveMarks(array $rows): bool {
        global $wpdb;
        $campus = ESP_CampusContext::id();
        $user_id = get_current_user_id();
        $now = current_time('mysql');

        foreach ($rows as $row) {
            $student_id = absint($row['student_id'] ?? 0);
            $exam_id = absint($row['exam_id'] ?? 0);
            $subject_id = absint($row['subject_id'] ?? 0);
            $obtained = (float)($row['obtained_marks'] ?? 0);
            $remarks = sanitize_text_field($row['remarks'] ?? '');

            if (!$student_id || !$exam_id || !$subject_id) {
                continue;
            }

            $existing = $wpdb->get_row($wpdb->prepare(
                "SELECT id, locked_at FROM {$this->table} WHERE campus_id=%d AND exam_id=%d AND student_id=%d AND subject_id=%d",
                $campus,
                $exam_id,
                $student_id,
                $subject_id
            ), ARRAY_A);

            if ($existing) {
                $wpdb->update(
                    $this->table,
                    [
                        'obtained_marks' => $obtained,
                        'remarks' => $remarks,
                        'submitted_by' => $user_id,
                        'updated_at' => $now,
                    ],
                    [
                        'id' => (int)$existing['id'],
                        'campus_id' => $campus,
                    ]
                );
            } else {
                $wpdb->insert(
                    $this->table,
                    [
                        'campus_id' => $campus,
                        'exam_id' => $exam_id,
                        'student_id' => $student_id,
                        'subject_id' => $subject_id,
                        'obtained_marks' => $obtained,
                        'remarks' => $remarks,
                        'submitted_by' => $user_id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }
        }

        return true;
    }
}
