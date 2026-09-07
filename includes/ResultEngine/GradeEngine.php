<?php

defined('ABSPATH') || exit;

class ESP_GradeEngine {

    public static function grade(float $percentage): string {
        foreach (self::rules() as $rule) {
            if ($percentage >= $rule['min']) return $rule['grade'];
        }
        return 'F';
    }

    public static function rules(): array {
        $raw = get_option('esp_grade_rules', [
            ['min'=>90,'grade'=>'A+'], ['min'=>80,'grade'=>'A'], ['min'=>70,'grade'=>'B'],
            ['min'=>60,'grade'=>'C'], ['min'=>50,'grade'=>'D'], ['min'=>40,'grade'=>'E'], ['min'=>0,'grade'=>'F'],
        ]);
        $rules = [];
        foreach ((array)$raw as $rule) {
            if (isset($rule['min'], $rule['grade']) && is_numeric($rule['min']) && sanitize_text_field($rule['grade']) !== '') {
                $rules[] = ['min'=>(float)$rule['min'], 'grade'=>sanitize_text_field($rule['grade'])];
            }
        }
        usort($rules, static fn($a,$b) => $b['min'] <=> $a['min']);
        return $rules ?: [['min'=>0,'grade'=>'F']];
    }

    public static function status(float $percentage, int $failedSubjects): string {

        if ($failedSubjects > 0) {
            return 'FAIL';
        }

        return $percentage < ESP_Common::option('default_pass_percentage', 33) ? 'FAIL' : 'PASS';

    }

}
