<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createManagers();
        $this->createBackenders();
        $this->createFrontenders();
    }

    public function createBackenders()
    {
        DB::table('persons')->insert([
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
                'name' => 'Backender DEVELOPER',
                'experience' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Backender DEVELOPER',
                'experience' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Backender INTERN',
                'experience' => 9,
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
            ],            [
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
            ],            [
                'person_id' => 5,
                'education_id' => 2,
            ],
        ]);
    }

    public function createManagers()
    {

    }

    public function createFrontenders()
    {

    }
}
