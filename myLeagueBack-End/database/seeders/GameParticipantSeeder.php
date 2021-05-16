<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameParticipant;

class GameParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //This resets the table, deleting all the data everytime the function is called
        GameParticipant::truncate();

        // GameParticipant::create([
        //     GameParticipant::GAME_ID_COLUMN_NAME => 1,
        //     GameParticipant::TEAM_ID_COLUMN_NAME => 1,
        //     GameParticipant::WIN_COLUMN_NAME => true,
        //     GameParticipant::OT_COLUMN_NAME => false,
        //     GameParticipant::GOALS_SHOT_COLUMN_NAME => 3,
        //     GameParticipant::GOALS_CONCEDED_COLUMN_NAME => 2
        // ]);

        // GameParticipant::create([
        //     GameParticipant::GAME_ID_COLUMN_NAME => 1,
        //     GameParticipant::TEAM_ID_COLUMN_NAME => 2,
        //     GameParticipant::WIN_COLUMN_NAME => false,
        //     GameParticipant::OT_COLUMN_NAME => false,
        //     GameParticipant::GOALS_SHOT_COLUMN_NAME => 2,
        //     GameParticipant::GOALS_CONCEDED_COLUMN_NAME => 3
        // ]);
    }
}
