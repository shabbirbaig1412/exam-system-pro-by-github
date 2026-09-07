<?php

defined('ABSPATH') || exit;

class ESP_AllocationRepository extends ESP_BaseRepository {

    protected string $table;

    public function __construct() {

        parent::__construct();

        $this->table =

            $this->db->prefix.'esp_allocations';

    }

    public function all(): array {

        return $this->db->get_results(

            $this->db->prepare(
                "SELECT a.*, c.class_name, s.subject_name, t.teacher_name
                 FROM {$this->table} a
                 LEFT JOIN {$this->db->prefix}esp_classes c ON c.id=a.class_id
                 LEFT JOIN {$this->db->prefix}esp_subjects s ON s.id=a.subject_id
                 LEFT JOIN {$this->db->prefix}esp_teachers t ON t.id=a.teacher_id
                 WHERE a.campus_id=%d AND a.session_id=%d
                 ORDER BY a.id DESC",
                ESP_CampusContext::id()
                , ESP_SessionContext::id()
            )

        );

    }

}
