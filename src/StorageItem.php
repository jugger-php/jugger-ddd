<?php

class StorageItem implements \ArrayAccess
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function offsetSet($offset, $value)
    {
       if ($this->offsetExists($offset)) {
           $this->fields[$offset] = $value;
       }
   }

   public function offsetExists($offset)
   {
       return isset($this->fields[$offset]);
   }

   public function offsetUnset($offset)
   {
       $this->fields[$offset] = null;
   }

   public function offsetGet($offset)
   {
       return $this->fields[$offset] ?? null;
   }
}
