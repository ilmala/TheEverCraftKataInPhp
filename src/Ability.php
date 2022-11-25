<?php

namespace EverKraft;

class Ability
{
    protected int $score = 10;

    public function setScore(int $score): static
    {
        if ($score < 1 || $score > 20) {
            throw new \Exception("Score value need to be between 1 and 20.");
        }
        $this->score = $score;

        return $this;
    }

    public function score(): int
    {
        return $this->score;
    }

    public function modifier(): int
    {
        return floor(($this->score() - 10) / 2);
    }
}