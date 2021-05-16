<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    const TABLE_NAME = 'teams';
    
    const TEAM_ID_COLUMN_NAME = 'team_id';
    const LEAGUE_ID_COLUMN_NAME = '_league_id';
    const NAME_COLUMN_NAME = 'name';

    protected $primaryKey = self::TEAM_ID_COLUMN_NAME;

    protected $fillable = [
        self::LEAGUE_ID_COLUMN_NAME,
        self::NAME_COLUMN_NAME
    ];
    protected $guarded = [];

    
}
