<?php

defined('ABSPATH') || exit;

class ESP_PositionService {

    public function assign(

        array &$results

    ): array {

        usort(

            $results,

            function($a,$b){

                return

                $b['percentage']

                <=>

                $a['percentage'];

            }

        );

        $position = 0;
        $rank = 0;
        $previous = null;

        foreach ($results as &$row) {
            $position++;
            $score = (float) ($row['percentage'] ?? 0);
            if ($previous === null || $score !== $previous) {
                $rank = $position;
                $previous = $score;
            }
            $row['position'] = $rank;

        }

        return $results;

    }

}
