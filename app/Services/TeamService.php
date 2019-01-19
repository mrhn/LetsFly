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
     * @param TeamComposition[] $teamComposition
     */
    public function suggest(Team $team, array $teamComposition)
    {
        $suggestion = [];

        foreach ($teamComposition as $composition) {
            $suggestions = $this->personService->combinationsBySkill($composition->skill, $composition->amount);
            $suggestion[$composition->skill] = $suggestions;
        }

        $return = [];

        $this->loop([], $suggestion, $return);

        $collection = collect($return)->each(function (Suggestion $suggestion) use ($team) {
            $suggestion->calculateFit($team);
        });

        $teamCompositon = $collection->sortBy('fit')->first();

        $this->saveTeamComposition($team, $teamCompositon);
    }

    private function loop(array $suggestion, array $rest, &$result): void
    {
        if (!count($rest)) {
            $result[] = new Suggestion($suggestion);

            return;
        }

        $keys = array_keys($rest);
        $key = array_shift($keys);
        $suggestions = $rest[$key];
        unset($rest[$key]);

        foreach ($suggestions as $tmp) {
            foreach ($tmp as $ele) {
                $ele->forSkill = $key;
            }

            $this->loop(array_merge($suggestion, $tmp), $rest, $result);
        }
    }

    private function saveTeamComposition(Team $team, Suggestion $finalTeam)
    {
        $people = collect($finalTeam->suggestions)->reduce(function (array $carry, Person $person) {
            $carry[$person->id] = ['skill' => $person->forSkill ?? ''];

            return $carry;
        }, []);

        $team->people()->sync($people);
    }
}
