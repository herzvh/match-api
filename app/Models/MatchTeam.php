<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchTeam extends Model
{
    protected $table = 'matches_teams';
    use HasFactory;

    protected $fillable = [
        'score',
        'type',
        'match_id',
        'team_id'
    ];
}
