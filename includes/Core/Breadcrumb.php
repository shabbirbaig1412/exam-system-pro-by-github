<?php

defined('ABSPATH') || exit;

class ESP_Breadcrumb {

    public static function show(

        string $title

    ): void {

        ?>

        <div class="esp-breadcrumb">

            <strong>

            Exam System

            </strong>

            /

            <?php echo esc_html($title); ?>

        </div>

        <?php

    }

}