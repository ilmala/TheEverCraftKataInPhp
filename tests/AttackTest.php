<?php
declare(strict_types=1);

namespace Test;

// As a combatant I want to be able to attack other combatants so that
// I can survive to fight another day
use EverKraft\Attack;
use EverKraft\Character;

// roll must meet or beat opponents armor class to hit
// Opponent base Armour class is 10
it('roll a 10 to hit opponent', function () {
    $opponent = new Character();
    $attack = new Attack($opponent);
    $haveHitOpponent = $attack->resolveHit(10);

    expect($haveHitOpponent)->toBeTrue;
});

it('roll a 9 to miss opponent', function () {
    $opponent = new Character();
    $attack = new Attack($opponent);
    $haveHitOpponent = $attack->resolveHit(9);

    expect($haveHitOpponent)->toBeFalse;
});

it('roll a natural 20 always hits opponent', function () {
    $opponent = new Character();
    $opponent->setArmorClass(25);
    $attack = new Attack($opponent);
    $haveHitOpponent = $attack->resolveHit(20);

    expect($haveHitOpponent)->toBeTrue;
});