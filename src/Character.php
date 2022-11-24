<?php

namespace EverKraft;

use EverKraft\Exceptions\InvalidAlignmentException;

class Character
{
    protected string $name;
    protected string $alignment = 'Neutral';
    protected int $armorClass = 10;
    protected int $hitPoints = 5;

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @param string $alignment
     * @return $this
     * @throws InvalidAlignmentException
     */
    public function setAlignment(string $alignment): static
    {
        if (!in_array($alignment, ['Good', 'Neutral', 'Evil'])) {
            throw new InvalidAlignmentException("Alignment can be only Good, Evil, and Neutral");
        }

        $this->alignment = $alignment;
        return $this;
    }

    public function alignment(): string
    {
        return $this->alignment;
    }

    public function setArmorClass(int $value): static
    {
        $this->armorClass = $value;
        return $this;
    }

    public function armorClass(): int
    {
        return $this->armorClass;
    }

    public function hitPoints(): int
    {
        return $this->hitPoints;
    }

    public function takeDamage(): void
    {
        $this->hitPoints -= 1;
    }

    public function takeCriticalDamage(): void
    {
        $this->hitPoints -= 2;
    }

    public function isDead(): bool
    {
        return $this->hitPoints <= 0;
    }
}