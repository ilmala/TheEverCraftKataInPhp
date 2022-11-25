<?php
declare(strict_types=1);

namespace Test;

use EverKraft\Attack;
use EverKraft\Character;

it('hit if a roll beat the armour class', function () {
    $hero = new Character;
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);
    $hitResult = $attack->resolveHit(12);

    expect($hitResult)->toBeTrue();
});

it('hit if a roll meet the armour class', function () {
    $hero = new Character;
    $opponent = new Character;

    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(10);

    expect($hitResult)->toBeTrue();
});

it('miss if a roll is less the armour class', function () {
    $hero = new Character;
    $opponent = new Character;

    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(6);

    expect($hitResult)->toBeFalse();
});

it('hit always if roll a natural 20', function () {
    $hero = new Character;
    $hero->strength->setScore(1); // -5
    $opponent = new Character;
    $opponent->dexterity->setScore(20); // +5

    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(20);

    expect($hitResult)->toBeTrue();
});

it('hit even if a roll is less the armour class if is strong', function () {
    $hero = new Character;
    $hero->strength->setScore(18); // +4
    $opponent = new Character;

    $attack = new Attack($hero, $opponent);
    $hitResult = $attack->resolveHit(6);

    expect($hitResult)->toBeTrue();
});

it('miss even if a roll beat the armour class if is weak', function () {
    $hero = new Character;
    $hero->strength->setScore(1); // -5
    $opponent = new Character;

    $attack = new Attack($hero, $opponent);
    $hitResult = $attack->resolveHit(14);

    expect($hitResult)->toBeFalse();
});

it('miss if opponent is able', function () {
    $hero = new Character;
    $opponent = new Character;
    $opponent->dexterity->setScore(18); // +4

    $attack = new Attack($hero, $opponent);
    $hitResult = $attack->resolveHit(12);

    expect($hitResult)->toBeFalse();
});


// Damage
it('add 1 point damage if hit', function () {
    $hero = new Character;
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(12);

    expect($opponent->hitPoints())->toBe(4);
});

it('double damage point if roll a natural 20', function () {
    $hero = new Character;
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(20);

    expect($opponent->hitPoints())->toBe(3);
});

it('cause more damage if is strong', function () {
    $hero = new Character;
    $hero->strength->setScore(15); // +2
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(12);

    expect($opponent->hitPoints())->toBe(2);
});

it('cause even more damage if is strong when roll a critical', function () {
    $hero = new Character;
    $hero->strength->setScore(15); // +2
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(20);

    expect($opponent->hitPoints())->toBe(-1);
});

it('cause less damage if is weak, minimum is always 1', function () {
    $hero = new Character;
    $hero->strength->setScore(5); // -3
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(14);

    expect($opponent->hitPoints())->toBe(4);
});

// Experience
it("gains 10 experience points when successful attack", function(){
    $hero = new Character;
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);
    $attack->resolveHit(14);

    expect($hero->experience())->toBe(10);
});