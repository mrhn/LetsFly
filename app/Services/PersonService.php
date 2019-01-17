<?php

namespace App\Services;

use App\Person;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PersonService
{
    public function bySkill(string $skill): Collection
    {
        return Person::whereHas('skills', function (Builder $query) use ($skill) {
            $query->where('name', $skill);
        })->get();
    }

    public function combinationsBySkill(string $skill, int $combinations): array
    {
        $result = [];

        $this->calculateCombinations([], $this->bySkill($skill)->toArray(), $combinations, $result);

        return $result;
    }

    private function calculateCombinations(array $start, array $rest, int $combinations, &$result): void
    {
        if ($combinations === 0) {
            $result[] = $start;

            return ;
        }

        $running = count($rest);
        for ($i = 0; $i < $running; $i++) {
            $newStart = array_merge($start, [array_pop($rest)]);

            $this->calculateCombinations($newStart, $rest, $combinations - 1, $result);
        }
    }
}
