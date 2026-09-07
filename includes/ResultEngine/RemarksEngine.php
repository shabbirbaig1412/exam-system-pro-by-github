<?php

defined('ABSPATH') || exit;

class ESP_RemarksEngine {

    public function remark(
        float $percentage,
        bool $passed
    ): string {

        if (!$passed) {

            return 'Failed';

        }

        if ($percentage >= 90) return 'Outstanding';

        if ($percentage >= 80) return 'Excellent';

        if ($percentage >= 70) return 'Very Good';

        if ($percentage >= 60) return 'Good';

        if ($percentage >= 50) return 'Satisfactory';

        return 'Pass';

    }

}