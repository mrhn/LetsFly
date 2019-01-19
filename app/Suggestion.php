<?php

namespace App;

class Suggestion
{
    /** @var array */
    public $suggestions;

    /** @var float */
    public $fit;

    public function __construct(array $suggestions)
    {
        $this->suggestions = $suggestions;
    }

    public function calculateFit(Team $team)
    {
        $sum = 0;
        /** @var Person $suggestion */
        foreach ($this->suggestions as $suggestion) {
            $skill = $suggestion->skills->where('name', $suggestion->forSkill)->first();
            $sum += $suggestion->skillLevel($skill);
        }
        $this->fit = abs($team->priorityValue - $sum / count($this->suggestions));
    }
}
