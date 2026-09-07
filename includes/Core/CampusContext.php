<?php

defined('ABSPATH') || exit;

class ESP_CampusContext {

    protected static int $campus = 0;

    public static function set(

        int $campusId

    ): void {

        self::$campus = $campusId;

    }

    public static function id(): int {

        if(self::$campus){

            return self::$campus;

        }

        return (int)get_user_meta(

            get_current_user_id(),

            'esp_campus_id',

            true

        );

    }

}