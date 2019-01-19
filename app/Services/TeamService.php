<?php

namespace App\Services;

use App\Person;
use App\Suggestion;
use App\Team;
use App\TeamComposition;

class TeamService
{
    /** @var PersonService */
    private $personService;

    public function __construct()
    {
        $this->personService = app(PersonService::class);
    }

    /**
     * Suggest a team composition and save it to the team
     * @param TeamComposition[] $teamComposition
     */
    public function suggest(Team $team, array $teamComposition): void
    {
        $suggestedCombinations = $this->calculateSuggestedCompositions($teamComposition);

        $collection = collect($suggestedCombinations)->each(function (Suggestion $suggestion) use ($team) {
            $suggestion->calculateFit($team);
        });

        $bestComposition = $collection->sortBy('fit')->first();

        $this->saveTeamComposition($team, $bestComposition);
    }

    /**
     * @param TeamComposition[] $teamComposition
     * @return Suggestion[]
     */
    private function calculateSuggestedCompositions(array $teamComposition): array
    {
        $combinations = [];
        $this->combineSuggestions([], $this->getSuggestionsBySkill($teamComposition), $combinations);

        return $combinations;
    }

    /**
     * @param TeamComposition[] $teamComposition
     */
    private function getSuggestionsBySkill(array $teamComposition): array
    {
        $suggestion = [];

        /** @var TeamComposition $composition */
        foreach ($teamComposition as $composition) {
            $suggestions = $this->personService->combinationsBySkill($composition->skill, $composition->amount);
            $suggestion[$composition->skill] = $suggestions;
        }
    }

    /**
     * @param Suggestion[] result
     */
    private function combineSuggestions(array $suggestions, array $rest, &$result): void
    {
        if (!count($rest)) {
            $result[] = new Suggestion($suggestions);

            return;
        }

        // get first element and unset it, need for the combination logic PHP 7.2 has a nicer way of doing this.
        $keys = array_keys($rest);
        $key = array_shift($keys);
        $suggestion = $rest[$key];
        unset($rest[$key]);

        // Suggestions is an array of array of persons
        foreach ($suggestions as $peopleSuggestion) {
            // Indicate why we select person with a temporary value
            foreach ($peopleSuggestion as $person) {
                $person->forSkill = $key;
            }

            // Combine the rest of the suggestions recursively
            $this->combineSuggestions(array_merge($suggestion, $peopleSuggestion), $rest, $result);
        }
    }

    private function saveTeamComposition(Team $team, Suggestion $finalTeam): void
    {
        $people = collect($finalTeam->suggestions)->reduce(function (array $carry, Person $person) {
            $carry[$person->id] = ['skill' => $person->forSkill ?? ''];

            return $carry;
        }, []);

        $team->people()->sync($people);
    }
}
