<?php

defined('ABSPATH') || exit;

class ESP_Sanitizer {

    public static function text(

        $value

    ): string {

        return sanitize_text_field(

            $value

        );

    }

    public static function textarea(

        $value

    ): string {

        return sanitize_textarea_field(

            $value

        );

    }

    public static function email(

        $value

    ): string {

        return sanitize_email(

            $value

        );

    }

    public static function number(

        $value

    ): float {

        return

        (float)$value;

    }

    public static function integer(

        $value

    ): int {

        return

        (int)$value;

    }

    public static function decimal($value): float {

        return (float) $value;

    }

    public static function status(

        $value

    ): int {

        return

        empty($value)

        ?0:1;

    }

}
