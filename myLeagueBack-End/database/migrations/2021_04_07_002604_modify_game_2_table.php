<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGame2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dateTime('game_date')->change();
            $table->renameColumn('game_date', 'date');

            $table->unsignedInteger('home_goals')->nullable()->change();
            $table->unsignedInteger('away_goals')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn('game_date');
            $table->dropColumn('home_team_id');
            $table->dropColumn('away_team_id');
            $table->dropColumn('home_goals');
            $table->dropColumn('away_goals');
            $table->dropColumn('OT');
        });
    }
}
