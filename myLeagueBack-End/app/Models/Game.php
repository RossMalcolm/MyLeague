<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    const TABLE_NAME = 'games';

    const GAME_ID_COLUMN_NAME = 'game_id';
    const LEAGUE_ID_COLUMN_NAME = '_league_id';
    const PLAYED_COLUMN_NAME = 'played';

    const DATE_COLUMN_NAME = 'date';
    const HOME_TEAM_ID_COLUMN_NAME = 'home_team_id';
    const AWAY_TEAM_ID_COLUMN_NAME = 'away_team_id';
    const HOME_GOALS_COLUMN_NAME = 'home_goals';
    const AWAY_GOALS_COLUMN_NAME = 'away_goals';
    const OT_COLUMN_NAME = 'OT';

    protected $primaryKey = self::GAME_ID_COLUMN_NAME;
    
    protected $fillable = [
        self::LEAGUE_ID_COLUMN_NAME,
        self::PLAYED_COLUMN_NAME,
        self::DATE_COLUMN_NAME,
        self::AWAY_TEAM_ID_COLUMN_NAME,
        self::HOME_GOALS_COLUMN_NAME,
        self::AWAY_GOALS_COLUMN_NAME,
        self::OT_COLUMN_NAME,
    ];
    
    protected $guarded = [];
}
