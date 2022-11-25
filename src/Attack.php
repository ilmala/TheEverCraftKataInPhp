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
        $isCriticalHit = $roll === 20;
        $roll = $roll + $this->character->strength->modifier();
        $hit = $roll >= $this->opponent->armorClass();

        if($isCriticalHit){
            $this->opponent->applyDamage(
                damage: $this->character->criticalDamage(),
            );
        }elseif($hit) {
            $this->opponent->applyDamage(
                damage: $this->character->baseDamage(),
            );
        }

        return $hit;
    }
}