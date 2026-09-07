<?php

defined('ABSPATH') || exit;

class ESP_Loader {

    private array $actions=[];

    public function addAction(

        string $hook,

        $object,

        string $method,

        int $priority=10,

        int $args=1

    ): void {

        $this->actions[] =

        compact(

            'hook',

            'object',

            'method',

            'priority',

            'args'

        );

    }

    public function run(): void {

        foreach(

            $this->actions

            as

            $action

        ){

            add_action(

                $action['hook'],

                [

                    $action['object'],

                    $action['method']

                ],

                $action['priority'],

                $action['args']

            );

        }

    }

}