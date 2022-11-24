<?php
declare(strict_types=1);

namespace Test;
use EverKraft\Character;
use EverKraft\Enums\Abilities;
use EverKraft\Exceptions\InvalidAbilitiesValueException;

it('have Ability default to 10', function (Abilities $ability) {
    $character = new Character;

    expect($character->getAbility($ability))->toBe(10);
})->with(array_combine(Abilities::values(),Abilities::cases()));

it('cant have Ability less than 1', function (Abilities $ability) {
    $character = new Character;
    $character->setAbility($ability, 0);
})->with(array_combine(Abilities::values(),Abilities::cases()))
    ->throws(InvalidAbilitiesValueException::class, "Strength Abilities in range from 1 to 20");

it('cant have Ability great than 20', function (Abilities $ability) {
    $character = new Character;
    $character->setAbility($ability, 21);
})->with(array_combine(Abilities::values(),Abilities::cases()))
    ->throws(InvalidAbilitiesValueException::class, "Strength Abilities in range from 1 to 20");

it('have Ability modifier', function (Abilities $ability, $value) {
    $character = new Character;
    $character->setAbility($ability, $value);
    expect($character->getAbilityModifier($ability))
        ->toBe(Character::$abilityModifiersTable[$value]);
})->with(array_combine(Abilities::values(),Abilities::cases()))
->with(range(1,20));