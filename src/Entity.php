<?php

abstract class Entity
{
    private $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public static function generateGuid(): string
    {
        $hex = bin2hex(random_bytes(16));
        $toks = str_split($hex, 2);
        $p1 = $toks[12].$toks[13].$toks[14].$toks[15];
        $p2 = $toks[10].$toks[11];
        $p3 = $toks[8].$toks[9];
        $p4 = $toks[7].$toks[6].$toks[5].$toks[4].$toks[3].$toks[2].$toks[1].$toks[0];
        return "{$p1}-{$p2}-{$p3}-{$p4}";
    }
}
