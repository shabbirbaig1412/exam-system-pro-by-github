<?php

defined('ABSPATH') || exit;

trait ESP_CrudTrait {

    public function find(

        int $id

    ) {

        return $this->db->get_row(

            $this->db->prepare(

                "SELECT *

                FROM {$this->table}

                WHERE id=%d",

                $id

            ),

            ARRAY_A

        );

    }

    public function insert(

        array $data

    ): int {

        $this->db->insert(

            $this->table,

            $data

        );

        return

            (int)$this->db->insert_id;

    }

    public function update(

        int $id,

        array $data

    ): bool {

        return (bool)

        $this->db->update(

            $this->table,

            $data,

            ['id'=>$id]

        );

    }

    public function delete(

        int $id

    ): bool {

        return (bool)

        $this->db->delete(

            $this->table,

            ['id'=>$id]

        );

    }

}