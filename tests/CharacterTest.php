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

it('hit points increase by 5 for each level + constitution modifier', function ($xp, $hp, $con) {
    $character = new Character;
    $character->constitution->setScore($con);
    $character->gainExperience($xp);
    expect($character->hitPoints())->toBe($hp);
})
    ->with([
        "Level 1 - Hp 5 - 10 Con" => [0, 5, 10],
        "Level 2 - Hp 10 - 10 Con" => [1000, 10, 10],
        "Level 3 - Hp 15 - 10 Con" => [2000, 15, 10],
        "Level 10 - Hp 50 - 10 Con" => [9000, 50, 10],
        "Level 2 - Hp 12 - 15 Con" => [1000, 12, 15],
        "Level 2 - Hp 8 - 6 Con" => [1000, 8, 6],
    ]);

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

// Levels
it("has Level defaults to 1", function () {
    $character = new Character;

    expect($character->level())->toBe(1);
});

it("with experience points gains a level", function ($xp, $level) {
    $character = new Character;
    $character->gainExperience($xp);

    expect($character->level())->toBe($level);
})
    ->with([
        "0 xp - 1 lvl" => ['xp' => 0, 'level' => 1],
        "999 xp - 1 lvl" => ['xp' => 999, 'level' => 1],
        "1000 xp - 2 lvl" => ['xp' => 1000, 'level' => 2],
        "2000 xp - 3 lvl" => ['xp' => 2000, 'level' => 3],
        "3000 xp - 4 lvl" => ['xp' => 3000, 'level' => 4],
        "9000 xp - 10 lvl" => ['xp' => 9000, 'level' => 10],
    ]);