<?php defined('ABSPATH') || exit; ?>

<div class="wrap esp-admin">

    <h1><?php esc_html_e('Exam System Dashboard','exam-system-pro'); ?></h1>

    <div class="esp-dashboard-grid">

        <?php ESP_DashboardStatsWidget::render(); ?>

    </div>

</div>
