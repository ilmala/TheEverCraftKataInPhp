<?php

namespace EverKraft;

class Attack
{
    public function __construct(protected Character $opponent)
    {
    }

    public function resolveHit(int $value): bool
    {
        if($value === 20) {
            return true;
        }
        return $value >= $this->opponent->armorClass();
    }
}