<?php
declare(strict_types=1);

namespace Test;

use EverKraft\Character;
use EverKraft\Enums\Alignment;
use TypeError;

it('can get and set the Name', function () {
    $character = new Character;
    $character->name = 'Uggiel';

    expect($character->name)->toBe("Uggiel");
});

// Alignment
it('can get and set the Alignment', function () {
    $character = new Character;
    $character->alignment = Alignment::Neutral;

    expect($character->alignment)->toBe(Alignment::Neutral);
});

it('can set valid alignment', function (Alignment $alignment) {
    $character = new Character;
    $character->alignment = $alignment;

    expect($character->alignment)->toBe($alignment);
})
    ->with([
    'Good' => Alignment::Good,
    'Neutral' => Alignment::Neutral,
    'Evil' => Alignment::Evil,
]);

it('can not set an invalid alignment', function () {
    $character = new Character;
    $character->alignment = 'invalid-alignment';

    expect($character->alignment)->toBe('invalid-alignment');
})
    ->throws(TypeError::class);

// Armor Class
it('has an Armor Class that defaults to 10', function () {
    $character = new Character;

    expect($character->armorClass())->toBe(10);
});

it('add positive Dexterity modifier to armor class', function () {
    $character = new Character;
    $character->dexterity->setScore(15);

    expect($character->armorClass())->toBe(12);
});

it('add negative Dexterity modifier to armor class', function () {
    $character = new Character;
    $character->dexterity->setScore(5);

    expect($character->armorClass())->toBe(7);
});

// Hit Points
it('has 5 Hit Points by default', function () {
    $character = new Character;

    expect($character->hitPoints())->toBe(5);
});

it('can add a positive Constitution modifier to Hit Points', function () {
    $character = new Character;
    $character->constitution->setScore(15); // +2

    expect($character->hitPoints())->toBe(7);
});

it('can add a negative Constitution modifier to Hit Points', function () {
    $character = new Character;
    $character->constitution->setScore(6); // -2

    expect($character->hitPoints())->toBe(3);
});

it('always at least 1 hit point', function () {
    $character = new Character;
    $character->constitution->setScore(1); // -5

    expect($character->hitPoints())->toBe(1);
});

it('is alive by default', function () {
    $character = new Character;
    expect($character->isAlive())->toBeTrue();
});

it('is alive for low damage ', function () {
    $character = new Character;
    $character->applyDamage(2);
    expect($character->isAlive())->toBeTrue();
});

it('is alive if have 1 hit point left', function () {
    $character = new Character;
    $character->applyDamage(4);
    expect($character->isAlive())->toBeTrue();
});

it('is dead when have 0 or less hit points ', function () {
    $character = new Character;
    $character->applyDamage(5);
    expect($character->isAlive())->toBeFalse();

    $character->applyDamage(2);
    expect($character->isAlive())->toBeFalse();
});

// Damage
it('get a default damage of 1', function () {
    $character = new Character;

    expect($character->baseDamage())->toBe(1);
});

it('add a positive Strength modifier to damage dealt', function () {
    $character = new Character;
    $character->strength->setScore(15); //+2

    expect($character->baseDamage())->toBe(3);
});

it('add a negative Strength modifier to damage dealt, minimum damage is always 1', function () {
    $character = new Character;
    $character->strength->setScore(6); //-2

    expect($character->baseDamage())->toBe(1);
});

it('get a critical damage of 2 double base damage', function () {
    $character = new Character;

    expect($character->criticalDamage())->toBe(2);
});

it('double Strength modifier on critical hits', function () {
    $character = new Character;
    $character->strength->setScore(15); //+2

    expect($character->criticalDamage())->toBe(6);
});

it('minimum damage is always 1 even on critical hits', function () {
    $character = new Character;
    $character->strength->setScore(1); //-5

    expect($character->criticalDamage())->toBe(1);
});

// Experience
it('has 0 Experience Points by default', function () {
    $character = new Character;

    expect($character->experience())->toBe(0);
});

it('can gains experience points', function () {
    $character = new Character;
    $character->gainExperience(10);

    expect($character->experience())->toBe(10);
});

