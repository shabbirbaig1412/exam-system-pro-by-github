<?php

defined('ABSPATH') || exit;

class ESP_Api {

    public static function register(): void {

        add_action(

            'rest_api_init',

            function () {

                register_rest_route(

                    'esp/v1',

                    '/ping',

                    [

                        'methods'  => 'GET',

                        'callback' => function () {

                            return [

                                'success' => true,

                                'version' => ESP_VERSION

                            ];

                        },

                        'permission_callback' => '__return_true'

                    ]

                );

            }

        );

    }

}