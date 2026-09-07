<?php

defined('ABSPATH') || exit;

class ESP_PositionCalculator {

    public static function calculate(

        array $students

    ): array {

        usort(

            $students,

            function ($a, $b) {
                $a_score = (float) ($a['percentage'] ?? $a['obtained'] ?? 0);
                $b_score = (float) ($b['percentage'] ?? $b['obtained'] ?? 0);
                return $b_score <=> $a_score;
            }

        );

        $position = 0;
        $rank = 0;
        $previous = null;

        foreach($students as &$student){
            $position++;
            $score = (float) ($student['percentage'] ?? $student['obtained'] ?? 0);
            if ($previous === null || $score !== $previous) {
                $rank = $position;
                $previous = $score;
            }
            $student['position']=$rank;

        }

        return $students;

    }

}
