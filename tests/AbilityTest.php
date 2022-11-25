<?php

declare(strict_types=1);

namespace Test;

use EverKraft\Ability;

it('as default score to 10', function () {
    $ability = new Ability;

    expect($ability->score())->toBe(10);
});

it('can not have score less than 1', function () {
    $ability = new Ability;
    $ability->setScore(0);
})->throws(\Exception::class);

it('can not have score great than 20', function () {
    $ability = new Ability;
    $ability->setScore(21);
})->throws(\Exception::class);

it('have modifier', function ($score, $modifier) {
    $ability = new Ability;
    $ability->setScore($score);

    expect($ability->modifier())->toBe($modifier);
})->with([
    ['score' => 1, 'modifier' => -5],
    ['score' => 2, 'modifier' => -4],
    ['score' => 3, 'modifier' => -4],
    ['score' => 4, 'modifier' => -3],
    ['score' => 5, 'modifier' => -3],
    ['score' => 6, 'modifier' => -2],
    ['score' => 7, 'modifier' => -2],
    ['score' => 8, 'modifier' => -1],
    ['score' => 9, 'modifier' => -1],
    ['score' => 10, 'modifier' => 0],
    ['score' => 11, 'modifier' => 0],
    ['score' => 12, 'modifier' => 1],
    ['score' => 13, 'modifier' => 1],
    ['score' => 14, 'modifier' => 2],
    ['score' => 15, 'modifier' => 2],
    ['score' => 16, 'modifier' => 3],
    ['score' => 17, 'modifier' => 3],
    ['score' => 18, 'modifier' => 4],
    ['score' => 19, 'modifier' => 4],
    ['score' => 20, 'modifier' => 5],
]);