<?php

defined('ABSPATH') || exit;

class ESP_CorePagination {

    public static function render(

        int $total,

        int $current,

        int $perPage

    ): void {

        echo paginate_links([

            'base'=>add_query_arg(

                'paged',

                '%#%'

            ),

            'format'=>'',

            'current'=>$current,

            'total'=>ceil(

                $total/$perPage

            )

        ]);

    }

}