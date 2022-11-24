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
            $this->opponent->takeCriticalDamage();
            return true;
        }
        if($value >= $this->opponent->armorClass()){
            $this->opponent->takeDamage();
            return true;
        }

        return false;
    }
}