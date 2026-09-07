<?php

defined('ABSPATH') || exit;

class ESP_Collection implements IteratorAggregate, Countable {

    private array $items=[];

    public function __construct(

        array $items=[]

    ){

        $this->items=$items;

    }

    public function all(): array {

        return

            $this->items;

    }

    public function first(){

        return

            $this->items[0]

            ??

            null;

    }

    public function count(): int {

        return

            count(

                $this->items

            );

    }

    public function getIterator(): Traversable {

        return

            new ArrayIterator(

                $this->items

            );

    }

}