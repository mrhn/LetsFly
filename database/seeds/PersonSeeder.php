<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createBackenders();
        $this->createManagers();
        $this->createFrontenders();
    }

    public function createBackenders()
    {
        DB::table('people')->insert([
            [
                'name' => 'Backender PHD',
                'experience' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Backender Senior',
                'experience' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Backender DEVELOPER 1',
                'experience' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Backender DEVELOPER 2',
                'experience' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Backender INTERN',
                'experience' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('person_skill')->insert([
            [
                'person_id' => 1,
                'skill_id' => 1,
                'coefficient' => 1.0,
            ],
            [
                'person_id' => 2,
                'skill_id' => 1,
                'coefficient' => 1.0,
            ],
            [
                'person_id' => 3,
                'skill_id' => 1,
                'coefficient' => 0.6,
            ],
            [
                'person_id' => 4,
                'skill_id' => 1,
                'coefficient' => 0.6,
            ], [
                'person_id' => 5,
                'skill_id' => 1,
                'coefficient' => 0.4,
            ],
        ]);

        DB::table('education_person')->insert([
            [
                'person_id' => 1,
                'education_id' => 5,
            ],
            [
                'person_id' => 2,
                'education_id' => 4,
            ],
            [
                'person_id' => 3,
                'education_id' => 3,
            ],
            [
                'person_id' => 4,
                'education_id' => 1,
            ], [
                'person_id' => 5,
                'education_id' => 2,
            ],
        ]);
    }

    public function createManagers()
    {
        DB::table('people')->insert([
            [
                'name' => 'Manager 1',
                'experience' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Manager 2',
                'experience' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Manager 3',
                'experience' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


        DB::table('person_skill')->insert(
            [
                [
                    'person_id' => 6,
                    'skill_id' => 3,
                    'coefficient' => 1.0,
                ],
                [
                    'person_id' => 7,
                    'skill_id' => 3,
                    'coefficient' => 0.8,
                ],
                [
                    'person_id' => 8,
                    'skill_id' => 3,
                    'coefficient' => 0.6,
                ],
            ]
        );

        DB::table('education_person')->insert([
            [
                'person_id' => 6,
                'education_id' => 4,
            ],
            [
                'person_id' => 7,
                'education_id' => 3,
            ],
            [
                'person_id' => 8,
                'education_id' => 2,
            ],
        ]);
    }

    public function createFrontenders()
    {
        DB::table('people')->insert([
            [
                'name' => 'Frontender 1',
                'experience' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Frontender 2',
                'experience' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Frontender 3',
                'experience' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


        DB::table('person_skill')->insert(
            [
                [
                    'person_id' => 9,
                    'skill_id' => 2,
                    'coefficient' => 1.0,
                ],
                [
                    'person_id' => 10,
                    'skill_id' => 2,
                    'coefficient' => 0.7,
                ],
                [
                    'person_id' => 11,
                    'skill_id' => 2,
                    'coefficient' => 0.4,
                ],
            ]
        );

        DB::table('education_person')->insert([
            [
                'person_id' => 9,
                'education_id' => 4,
            ],
            [
                'person_id' => 10,
                'education_id' => 3,
            ],
            [
                'person_id' => 11,
                'education_id' => 2,
            ],
        ]);
    }
}
