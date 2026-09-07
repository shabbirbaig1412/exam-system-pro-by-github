<?php

defined('ABSPATH') || exit;

class ESP_Widget {

    public static function statistic(

        string $title,

        $value,

        string $icon='dashicons-chart-bar'

    ): void {

        ?>

        <div class="esp-card esp-widget">

            <span class="dashicons <?php echo esc_attr($icon); ?>"></span>

            <h3><?php echo esc_html($title); ?></h3>

            <h1><?php echo esc_html($value); ?></h1>

        </div>

        <?php

    }

}