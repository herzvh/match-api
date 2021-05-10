<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scoreboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_name',
        'localteam_score',
        'visitorteam_score'
    ];

    public function match() {
        return $this->hasOne(Match::class, 'match_id');
    }
}
