<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\League;

class LeagueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //This resets the table, deleting all the data everytime the function is called
        League::truncate();

        League::create([
            League::NAME_COLUMN_NAME => 'Test League',
            League::EMAIL_COLUMN_NAME => 'test@test.com'
        ]);

        League::create([
            League::NAME_COLUMN_NAME => 'Test League 2',
            League::EMAIL_COLUMN_NAME => 'test2@test.com'
        ]);

    }
}
