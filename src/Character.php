<?php

namespace EverKraft;

use EverKraft\Enums\Abilities;
use EverKraft\Exceptions\InvalidAbilitiesValueException;
use EverKraft\Exceptions\InvalidAlignmentException;

class Character
{
    protected string $name;
    protected string $alignment = 'Neutral';
    protected int $armorClass = 10;
    protected int $hitPoints = 5;
    protected array $abilities = [];
    protected array $abilityModifiers = [];

    public static array $abilityModifiersTable = [
        1 => -5,
        2 => -4,
        3 => -4,
        4 => -3,
        5 => -3,
        6 => -2,
        7 => -2,
        8 => -1,
        9 => -1,
        10 => 0,
        11 => 0,
        12=> 1,
        13 => 1,
        14 => 2,
        15 => 2,
        16 => 3,
        17 => 3,
        18 => 4,
        19 => 4,
        20 => 5,
    ];

    public function __construct()
    {
        $this->abilities = array_combine(
            Abilities::values(),
            array_fill(0, count(Abilities::values()), 10)
        );

        $this->abilityModifiers = array_combine(
            Abilities::values(),
            array_fill(0, count(Abilities::values()), 0)
        );
    }

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

    /**
     * @throws InvalidAbilitiesValueException
     */
    public function setAbility(Abilities $ability, int $value): static
    {
        if($value < 1 || $value > 20) {
            throw new InvalidAbilitiesValueException("Strength Abilities in range from 1 to 20");
        }

        $this->abilities[$ability->value] = $value;
        $this->setAbilityModifier($ability, $value);

        return $this;
    }

    public function getAbility(Abilities $ability): int
    {
        return $this->abilities[$ability->value] ;
    }

    public function setAbilityModifier(Abilities $ability, int $value): static
    {
        $this->abilityModifiers[$ability->value] = self::$abilityModifiersTable[$value];

        return $this;
    }

    public function getAbilityModifier(Abilities $ability): int
    {
        return $this->abilityModifiers[$ability->value] ;
    }
}