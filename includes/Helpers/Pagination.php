<?php

defined('ABSPATH') || exit;

class ESP_Pagination {

    public static function links(

        int $total,

        int $perPage,

        int $current

    ): string {

        return paginate_links([

            'total'=>

                ceil($total/$perPage),

            'current'=>$current,

            'type'=>'plain'

        ]);

    }

}