<?php

class StorageItemCollection implements \Iterator
{
    private $items;
    private $position;

    public function __construct(array $items)
    {
        $this->items = [];
        $this->position = 0;

        foreach ($items as $item) {
            if ($item instanceof StorageItem) {
                $this->items[] = $item;
            }
        }
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position++;
    }

    public function valid()
    {
        return isset($this->items[$this->position]);
    }
}
