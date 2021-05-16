<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_participants', function (Blueprint $table) {
            $table->id('game_participant_id');
            $table->unsignedBigInteger('_game_id');
            $table->unsignedBigInteger('_team_id');
            $table->boolean('win');
            $table->boolean('OT')->default(false);
            $table->unsignedTinyInteger('goals_shot')->default(0);
            $table->unsignedTinyInteger('goals_conceded')->default(0);
            $table->timestamps();

            $table->foreign('_game_id')->references('game_id')->on('games');
            $table->foreign('_team_id')->references('team_id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_participants', function (Blueprint $table) {
            $table->dropForeign('_game_id');
            $table->dropForeign('_team_id');
        });
        Schema::dropIfExists('game_participants');
    }
}
