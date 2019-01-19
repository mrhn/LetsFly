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

    /**
     * Calculated how well a set of Person will fit the team
     */
    public function calculateFit(Team $team)
    {
        $sum = 0;
        /** @var Person $suggestion */
        foreach ($this->suggestions as $suggestion) {
            $skill = $suggestion->getSkill($suggestion->forSkill);
            $sum += $suggestion->skillLevel($skill);
        }

        // Teams priority is converted into a value and matched how much it fits
        $this->fit = abs($team->priorityValue - $sum / count($this->suggestions));
    }
}
