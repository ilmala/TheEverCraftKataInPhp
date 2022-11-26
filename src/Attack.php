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
        $isCriticalHit = $this->isCriticalHit($roll);
        $isHit = $this->isHit($roll);

        if ($isHit) {
            $this->applyExperience();
        }

        $this->applyDamage($isCriticalHit, $isHit);

        return $isHit;
    }

    protected function isCriticalHit(int $roll): bool
    {
        return $roll === 20;
    }

    protected function isHit(int $roll): bool
    {
        $roll = $roll + $this->character->strength->modifier();
        return $roll >= $this->opponent->armorClass();
    }

    protected function applyExperience(): void
    {
        $this->character->gainExperience(10);
    }

    protected function applyDamage(bool $isCriticalHit, bool $isHit): void
    {
        if ($isCriticalHit) {
            $this->opponent->applyDamage(
                damage: $this->character->criticalDamage(),
            );
        } elseif ($isHit) {
            $this->opponent->applyDamage(
                damage: $this->character->baseDamage(),
            );
        }
    }
}