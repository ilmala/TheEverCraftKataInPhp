<?php
declare(strict_types=1);

namespace EverKraft;

use EverKraft\Enums\Alignment;

class Character
{
    public string $name;
    public Alignment $alignment = Alignment::Neutral;
    protected int $armorClass = 10;
    protected int $hitPoints = 5;
    public int $damage = 0;
    public Ability $constitution;
    public Ability $dexterity;
    public Ability $strength;

    public function __construct()
    {
        $this->constitution = new Ability();
        $this->dexterity = new Ability();
        $this->strength = new Ability();
    }

    public function armorClass(): int
    {
        return $this->armorClass + $this->dexterity->modifier();
    }

    public function hitPoints(): int
    {
        return max($this->hitPoints + $this->constitution->modifier(), 1) - $this->damage;
    }

    public function applyDamage(int $damage): void
    {
        $this->damage += $damage;
    }

    public function baseDamage(): int
    {
        $damage = 1 + $this->strength->modifier();
        return max($damage, 1);
    }

    public function criticalDamage(): int
    {
        $damage = 2 + ($this->strength->modifier() * 2);
        return max($damage, 1);
    }

    public function isAlive(): bool
    {
        return $this->hitPoints() > 0;
    }
}