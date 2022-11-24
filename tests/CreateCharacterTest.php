<?php
declare(strict_types=1);

namespace Test;
// As a character I want to have a name so that
// I can be distinguished from other characters
use EverKraft\Character;
use EverKraft\Exceptions\InvalidAlignmentException;

it('can get and set Name', function () {
    $character = new Character;
    $character->setName('Uggiel');

    expect($character->name())->toBe("Uggiel");
});

// As a character I want to have an alignment so that
// I have something to guide my actions
it('can get and set Alignment', function () {
    $character = new Character;
    $character->setAlignment('Neutral');

    expect($character->alignment())->toBe("Neutral");
});

it('can be alignments Good', function () {
    $character = new Character;
    $character->setAlignment('Good');

    expect($character->alignment())->toBe("Good");
});

it('can be alignments Neutral', function () {
    $character = new Character;
    $character->setAlignment('Neutral');

    expect($character->alignment())->toBe("Neutral");
});

it('can be alignments Evil', function () {
    $character = new Character;
    $character->setAlignment('Evil');

    expect($character->alignment())->toBe("Evil");
});

it('can have default alignments to Neutral', function () {
    $character = new Character;

    expect($character->alignment())->toBe("Neutral");
});

it('can not be invalid alignments', function () {
    $character = new Character;
    $character->setAlignment('invalid-alignment');
})->throws(InvalidAlignmentException::class, "Alignment can be only Good, Evil, and Neutral");

// As a combatant I want to have an armor class and hit points so that
// I can resist attacks from my enemies
it('has an Armor Class that defaults to 10', function () {
    $character = new Character;

    expect($character->armorClass())->toBe(10);
});

it('can set Armor Class', function () {
    $character = new Character;
    $character->setArmorClass(20);
    var_dump($character->armorClass());
    expect($character->armorClass())->toBe(20);
});

it('has 5 Hit Points by default', function () {
    $character = new Character;

    expect($character->hitPoints())->toBe(5);
});