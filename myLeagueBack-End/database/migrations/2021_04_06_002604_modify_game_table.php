<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGameTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->date('game_date');
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id');
            $table->unsignedInteger('home_goals');
            $table->unsignedInteger('away_goals');
            $table->boolean('OT')->default(false);
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
