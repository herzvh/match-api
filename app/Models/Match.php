<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'status',
        'round',
        'type',
        'timer',
        'date',
        'time',
        'league_id'
    ];

    public function league()
    {
        return $this->hasOne(League::class, 'id', 'league_id');
    }

    public function scoreboard()
    {
        return $this->hasOne(Scoreboard::class, 'id', 'scoreboard_id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'matches_teams');
    }
}
