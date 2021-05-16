<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //This resets the table, deleting all the data everytime the function is called
        Game::truncate();

        // Game::create([
        //     Game::LEAGUE_ID_COLUMN_NAME => 1,
        //     Game::PLAYED_COLUMN_NAME => true
        // ]);

        // Game::create([
        //     Game::LEAGUE_ID_COLUMN_NAME => 2
        // ]);
    }
}
