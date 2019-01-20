<?php

namespace Tests\Feature;

use App\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed');
    }

    public function testTeamGet()
    {
        /** @var Team $team */
        $team = factory(Team::class)->create();

        $this->json('GET', 'api/teams/' . $team->id)
            ->assertOk()
            ->assertJson(
                [
                    'data' => [
                        'name' => $team->name,
                        'priority' => $team->priority,
                    ],
                ]
            );
    }

    public function testTeamGet404()
    {
        $this->json('GET', 'api/teams/' . 404)
            ->assertStatus(404)
            ->assertJson(
                [
                    'message' => 'Team not found',
                    'code' => 404,
                    'status' => 'fail',
                    'data' => null,
                ]
            );
    }


    public function testTeamCreate()
    {
        $response = $this->json('POST', 'api/teams', $this->createData());

        $response->assertStatus(201)
            ->assertJson(
                [
                    'data' => [
                        'name' => 'martins team',
                        'priority' => 'medium',
                        'people' => $this->peopleReponse(),
                    ],
                ]
            );

        // check if the fit is close to 100% can deviate with half a percent
        $this->assertEquals(
            json_decode($response->getContent())->data->fit,
            100,
            'Fit is not close enough',
            0.5
        );
    }

    public function testTeamCreateValidationError()
    {
        $response = $this->json('POST', 'api/teams', []);

        $response->assertStatus(422)
            ->assertJson(
                [
                    'message' => 'Validation error',
                    'code' => 422,
                    'status' => 'fail',
                    'data' => [
                        'name' => [
                            "The name field is required."
                        ],
                        'priority' => [
                            "The priority field is required."
                        ],
                        'team' => [
                            'The team field is required.'
                        ],
                    ],
                ]
            );
    }

    private function createData(): array
    {
        return [
            'name' => 'martins team',
            'priority' => 'medium',
            'team' => [
                [
                    'skill' => 'Backender',
                    'amount' => 2
                ],
                [
                    'skill' => 'Manager',
                    'amount' => 2
                ],
                [
                    'skill' => 'Frontender',
                    'amount' => 2
                ]
            ],
        ];
    }

    private function peopleReponse(): array
    {
        return [
            [
                'id' => 5,
                'name' => 'Backender INTERN',
                'experience' => 2,
                'forSkill' => 'Backender',
                'skillLevels' => [
                    'Backender' => 0.25
                ]
            ],
            [
                'id' => 2,
                'name' => 'Backender Senior',
                'experience' => 1,
                'forSkill' => 'Backender',
                'skillLevels' => [
                    'Backender' => 0.72
                ]
            ],
            [
                'id' => 8,
                'name' => 'Manager 3',
                'experience' => 1,
                'forSkill' => 'Manager',
                'skillLevels' => [
                    'Manager' => 0.34
                ]
            ],
            [
                'id' => 7,
                'name' => 'Manager 2',
                'experience' => 2,
                'forSkill' => 'Manager',
                'skillLevels' => [
                    'Manager' => 0.58
                ]
            ],
            [
                'id' => 11,
                'name' => 'Frontender 3',
                'experience' => 0,
                'forSkill' => 'Frontender',
                'skillLevels' => [
                    'Frontender' => 0.2
                ]
            ],
            [
                'id' => 9,
                'name' => 'Frontender 1',
                'experience' => 5,
                'forSkill' => 'Frontender',
                'skillLevels' => [
                    'Frontender' => 0.9
                ]
            ]
        ];
    }
}
