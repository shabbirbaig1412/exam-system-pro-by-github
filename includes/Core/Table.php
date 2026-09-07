<?php

defined('ABSPATH') || exit;

abstract class ESP_Table extends WP_List_Table {

    public function no_items() {

        esc_html_e(

            'No records found.',

            'exam-system-pro'

        );

    }

    public function get_bulk_actions() {

        return [

            'delete'=>'Delete'

        ];

    }

    public function column_cb($item){

        return sprintf(

            '<input type="checkbox" name="ids[]" value="%d">',

            $item->id

        );

    }

}