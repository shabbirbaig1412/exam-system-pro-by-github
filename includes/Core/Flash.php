<?php

defined('ABSPATH') || exit;

class ESP_Flash {

    public static function set(

        string $type,

        string $message

    ): void {

        set_transient(

            'esp_flash',

            [

                'type'=>$type,

                'message'=>$message

            ],

            30

        );

    }

    public static function show(): void {

        $flash =

            get_transient(

                'esp_flash'

            );

        if(

            empty($flash)

        ){

            return;

        }

        delete_transient(

            'esp_flash'

        );

        ?>

        <div class="notice notice-<?php

        echo esc_attr(

            $flash['type']

        );

        ?>">

        <p>

        <?php

        echo esc_html(

            $flash['message']

        );

        ?>

        </p>

        </div>

        <?php

    }

}