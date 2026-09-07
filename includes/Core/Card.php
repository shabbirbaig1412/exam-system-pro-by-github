<?php

defined('ABSPATH') || exit;

class ESP_Card {

    public static function open(

        string $title

    ): void {

        ?>

        <div class="esp-card">

            <h2>

                <?php

                echo esc_html($title);

                ?>

            </h2>

        <?php

    }

    public static function close(): void {

        ?>

        </div>

        <?php

    }

}