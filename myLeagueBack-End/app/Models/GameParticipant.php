<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameParticipant extends Model
{
    use HasFactory;

    const GAME_PARTICIPANT_ID_COLUMN_NAME = 'game_participant_id';
    const GAME_ID_COLUMN_NAME = '_game_id';
    const TEAM_ID_COLUMN_NAME = '_team_id';
    const WIN_COLUMN_NAME = 'win';
    const OT_COLUMN_NAME = 'OT';
    const GOALS_SHOT_COLUMN_NAME = 'goals_shot';
    const GOALS_CONCEDED_COLUMN_NAME = 'goals_conceded';

    protected $primaryKey = self::GAME_PARTICIPANT_ID_COLUMN_NAME;

    protected $fillable = [
        self::GAME_ID_COLUMN_NAME, 
        self::TEAM_ID_COLUMN_NAME, 
        self::WIN_COLUMN_NAME,
        self::OT_COLUMN_NAME,
        self::GAME_ID_COLUMN_NAME,
        self::GOALS_CONCEDED_COLUMN_NAME,
    ];

    protected $guarded = [];
}
