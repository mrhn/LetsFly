<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function create(CreateTeamRequest $request)
    {
        $validated = $request->validated();
        /** @var Team $team */
        $team = Team::create(array_only($validated, ['name', 'priority']));

        $team->suggestTeam($validated['team']);

        return $team;
    }
}
