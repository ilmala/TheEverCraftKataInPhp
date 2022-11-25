<?php

namespace EverKraft;

class Attack
{
    public function __construct(
        protected Character $character,
        protected Character $opponent,
    )
    {
    }

    public function resolveHit(int $roll): bool
    {
        // todo: add str mod to roll
        $isCriticalHit = $roll === 20;
        $hit = $roll >= $this->opponent->armorClass();

        if($isCriticalHit){
            $this->opponent->damage(2);
        }elseif($hit) {
            $this->opponent->damage(1);
        }

        return $hit;
    }
}