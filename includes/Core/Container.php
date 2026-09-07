<?php

defined('ABSPATH') || exit;

class ESP_Container {

    private static array $bindings = [];

    public static function singleton(

        string $abstract,

        callable $resolver

    ): void {

        self::$bindings[$abstract] =

            $resolver;

    }

    public static function make(

        string $abstract

    ) {

        if (

            isset(

                self::$bindings[$abstract]

            )

        ) {

            return

                call_user_func(

                    self::$bindings[$abstract]

                );

        }

        return new $abstract();

    }

}