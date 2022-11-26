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
        $modifiedRoll = $this->resolveRoll($roll);
        $isCriticalHit = $this->isCriticalHit($roll);
        $isHit = $this->isHit($modifiedRoll);

        if ($isHit) {
            $this->applyExperience();
        }

        $this->applyDamage($isCriticalHit, $isHit);

        return $isHit;
    }

    public function resolveRoll(int $roll): int
    {
        $levelBonus = floor($this->character->level() / 2);

        return $roll + $levelBonus + $this->character->strength->modifier();
    }

    protected function isCriticalHit(int $roll): bool
    {
        return $roll === 20;
    }

    protected function isHit(int $roll): bool
    {
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