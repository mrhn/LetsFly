<?php

namespace Tests\Feature;

use App\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonControllerTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function testPersonAll()
    {
        /** @var Team $team */
        $team = factory(Team::class)->create();

        $response = $this->json('GET', 'api/people')
            ->assertOk()
            ->assertJsonFragment(
                [
                    'name' => 'Backender PHD',
                    'experience' => 3,
                    'skillLevels' => [
                        'Backender' => 1.0,
                    ]
                ]
            );
    }
}
