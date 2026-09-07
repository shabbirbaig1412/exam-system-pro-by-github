<?php

defined('ABSPATH') || exit;

class ESP_MarksProgressWidget {

    public static function render(): void {

        ?>

        <div class="esp-progress-widget">

            <strong>

                Progress:

            </strong>

            <span id="esp_progress">

                0%

            </span>

        </div>

        <?php

    }

}