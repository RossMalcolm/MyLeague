<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LeagueTableSeeder::class);
        $this->call(TeamTableSeeder::class);
        $this->call(GameSeeder::class);
        $this->call(GameParticipantSeeder::class);
    }
}
