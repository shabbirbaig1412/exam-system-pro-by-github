<?php

defined('ABSPATH') || exit;

abstract class ESP_CampusAwareRepository extends ESP_BaseRepository {

    protected function campusId(): int {

        return ESP_CampusContext::id();

    }

    public function find(int $id) {
        return $this->db->get_row($this->db->prepare(
            "SELECT * FROM {$this->table} WHERE id=%d AND campus_id=%d",
            $id, $this->campusId()
        ), ARRAY_A);
    }

    public function update(int $id, array $data): bool {
        $data['campus_id'] = $this->campusId();
        return (bool) $this->db->update($this->table, $data, ['id' => $id, 'campus_id' => $this->campusId()]);
    }

    public function delete(int $id): bool {
        return (bool) $this->db->delete($this->table, ['id' => $id, 'campus_id' => $this->campusId()]);
    }

}
