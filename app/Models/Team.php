<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'player_id'
    ];

    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'player_id');
    }

    public function matches()
    {
        return $this->belongsToMany(Match::class, 'matches_teams');
    }
}
