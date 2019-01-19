<?php

namespace App\Jobs;

use App\Services\TeamService;
use App\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SuggestTeamJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var Team */
    private $team;

    /** @var array */
    private $teamComposition;

    /** @var TeamService */
    private $teamService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Team $team, array $teamComposition)
    {
        $this->team = $team;
        $this->teamComposition = $teamComposition;
        $this->teamService = app(TeamService::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->teamService->suggest($this->team, $this->teamComposition);
    }
}
