<?php

defined('ABSPATH') || exit;

if (!class_exists('WP_List_Table')) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

class ESP_SubjectListTable extends WP_List_Table {

    public function get_columns(): array {

        return [

            'id'=>'ID',

            'subject_name'=>'Subject',

            'subject_code'=>'Code',

            'total_marks'=>'Total marks'
            ,'actions'=>'Actions'

        ];

    }

    public function prepare_items(): void {

        $repo=ESP_Container::make(
            ESP_SubjectRepository::class
        );

        $this->items=$repo->all();

    }

    public function column_default(
        $item,
        $column
    ){

        return $item[$column] ?? '';

    }

    public function column_actions($item): string {
        return sprintf(
            '<a class="button button-small" href="%s">Edit</a> <form method="post" action="%s" style="display:inline">%s<input type="hidden" name="action" value="esp_delete_record"><input type="hidden" name="entity" value="subjects"><input type="hidden" name="id" value="%d"><button class="button-link-delete" onclick="return confirm(\'Delete this subject?\')">Delete</button></form>',
            esc_url(add_query_arg(['page' => 'esp-subjects', 'edit_id' => absint($item['id'])], admin_url('admin.php'))),
            esc_url(admin_url('admin-post.php')),
            wp_nonce_field('esp_admin_record', '_wpnonce', true, false),
            absint($item['id'])
        );
    }

}
