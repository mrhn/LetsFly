<?php

namespace App;

class TeamComposition
{
    /** @var integer */
    public $amount;

    /** @var string */
    public $skill;

    public function __construct(int $amount, string $skill)
    {
        $this->amount = $amount;
        $this->skill = $skill;
    }
}
