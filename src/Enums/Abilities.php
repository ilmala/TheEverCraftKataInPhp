<?php

namespace EverKraft\Enums;

enum Abilities: string
{
    case Strength = 'strength';
    case Dexterity = 'dexterity';
    case Constitution = 'constitution';
    case Wisdom = 'wisdom';
    case Intelligence = 'intelligence';
    case Charisma = 'charisma';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
