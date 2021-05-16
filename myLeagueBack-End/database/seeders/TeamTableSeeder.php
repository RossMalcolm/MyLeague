<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        //This resets the table, deleting all the data everytime the function is called
        Team::truncate();

        Team::create([
            Team::LEAGUE_ID_COLUMN_NAME => 1,
            Team::NAME_COLUMN_NAME => 'Test Team'
        ]);

        Team::create([
            Team::LEAGUE_ID_COLUMN_NAME => 1,
            Team::NAME_COLUMN_NAME => 'Test Team 2'
        ]);
    }
}
