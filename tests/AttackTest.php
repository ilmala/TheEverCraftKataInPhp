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
    $opponent = new Character;

    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(20);

    expect($hitResult)->toBeTrue();
});

it('add 1 point damage if hit', function () {
    $hero = new Character;
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(12);

    expect($opponent->hitPoints())->toBe(4);
});

it('double damage point if hit a natural 20', function () {
    $hero = new Character;
    $opponent = new Character;
    $attack = new Attack($hero, $opponent);

    $hitResult = $attack->resolveHit(20);

    expect($opponent->hitPoints())->toBe(3);
});