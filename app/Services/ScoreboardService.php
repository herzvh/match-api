<?php


namespace App\Services;


use App\Models\Scoreboard;

class ScoreboardService
{
    public function saveOrUpdateScoreboard($matchId, $periods)
    {
        foreach ($periods as $period) {
            if (isset($period['@attributes']) && !empty($period['@attributes'])) {
                $scoreboard = $period['@attributes'];
                $scoreboardSaved = Scoreboard::firstOrNew(array(
                    'period_name' => $scoreboard['name'],
                    'match_id' => $matchId
                ));
                $scoreboardSaved->period_name = $scoreboard['name'];
                $scoreboardSaved->localteam_score = $scoreboard['localteam'];
                $scoreboardSaved->visitorteam_score = $scoreboard['visitorteam'];
                $scoreboardSaved->match_id = $matchId;
                $scoreboardSaved->save();
            }
        }
    }
}
