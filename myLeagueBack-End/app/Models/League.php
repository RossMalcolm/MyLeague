<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    const TABLE_NAME = 'leagues';

    const LEAGUE_ID_COLUMN_NAME = 'league_id';
    const EMAIL_COLUMN_NAME = 'email';
    const NAME_COLUMN_NAME = 'name';

    protected $primaryKey = self::LEAGUE_ID_COLUMN_NAME;

    protected $fillable = [
        self::EMAIL_COLUMN_NAME, 
        self::NAME_COLUMN_NAME
    ];
    
    protected $guarded = [];

    
}
