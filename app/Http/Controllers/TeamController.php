<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Resources\TeamResource;
use App\Team;
use App\TeamComposition;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamController extends Controller
{
    public function get(Request $request, int $id): JsonResource
    {
        return new TeamResource(Team::findOrFail($id));
    }

    public function create(CreateTeamRequest $request): JsonResource
    {
        $validated = $request->validated();
        /** @var Team $team */
        $team = Team::create(array_only($validated, ['name', 'priority']));

        $team->suggestTeam($this->parseTeamComposition($validated['team']));

        return new TeamResource($team);
    }

    /**
     * @param array $teamComposition
     * @return TeamComposition[]
     */
    private function parseTeamComposition(array $teamComposition): array
    {
        return array_map(function (array $teamComp): TeamComposition {
            return new TeamComposition($teamComp['amount'], $teamComp['skill']);
        }, $teamComposition);
    }
}
