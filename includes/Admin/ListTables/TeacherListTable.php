<?php

defined('ABSPATH') || exit;

if (!class_exists('WP_List_Table')) {

    require_once ABSPATH .
        'wp-admin/includes/class-wp-list-table.php';

}

class ESP_TeacherListTable extends WP_List_Table {

    public function get_columns(): array {

        return [

            'cb'     => '<input type="checkbox">',
            'id'     => 'ID',
            'teacher_name' => 'Teacher',
            'email'  => 'Email',
            'mobile' => 'Phone',
            'status' => 'Status'
            ,'actions' => 'Actions'

        ];

    }

    public function prepare_items(): void {

        $repo = ESP_Container::make(
            ESP_TeacherRepository::class
        );

        $this->items = $repo->all();

    }

    public function column_default(
        $item,
        $column
    ) {

        return $item[$column] ?? '';

    }

    public function column_actions($item): string {
        return sprintf(
            '<a class="button button-small" href="%s">Edit</a> <form method="post" action="%s" style="display:inline">%s<input type="hidden" name="action" value="esp_delete_record"><input type="hidden" name="entity" value="teachers"><input type="hidden" name="id" value="%d"><button class="button-link-delete" onclick="return confirm(\'Delete this teacher?\')">Delete</button></form>',
            esc_url(add_query_arg(['page' => 'esp-teachers', 'edit_id' => absint($item['id'])], admin_url('admin.php'))),
            esc_url(admin_url('admin-post.php')),
            wp_nonce_field('esp_admin_record', '_wpnonce', true, false),
            absint($item['id'])
        );
    }

}
