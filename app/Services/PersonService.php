<?php

namespace App\Services;

use App\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PersonService
{
    /**
     * Retrie persons with the given skill
     */
    public function bySkill(string $skill): Collection
    {
        return Person::whereHas('skills', function (Builder $query) use ($skill) {
            $query->where('name', $skill);
        })->get();
    }

    /**
     * Make combinations by a certain skill
     * So that all different combinations are presented in a array, to later find the best fit.
     */
    public function combinationsBySkill(string $skill, int $combinations): array
    {
        $result = [];
        $this->calculateCombinations([], $this->bySkill($skill)->all(), $combinations, $result);

        return $result;
    }

    /**
     * Recursive function to calculate the different combinations of people
     * @param array $result Array of an array of combinations with People objects
     */
    private function calculateCombinations(array $start, array $rest, int $combinations, &$result): void
    {
        if ($combinations === 0) {
            $result[] = $start;

            return ;
        }

        $length = count($rest);
        for ($i = 0; $i < $length; $i++) {
            $newStart = array_merge($start, [array_pop($rest)]);

            $this->calculateCombinations($newStart, $rest, $combinations - 1, $result);
        }
    }
}
