<?php


namespace App\Services;


use App\Models\Player;
use App\Models\Team;

class TeamService
{
    public function saveOrUpdateTeam($id, $name)
    {
        $start  = strpos($name, '(');
        $end    = strpos($name, ')', $start + 1);
        $length = $end - $start;
        $playerName = substr($name, $start + 1, $length - 1);
        $teamName = substr($name, 0, $start - 1);
        $player = $this->saveOrUpdatePlayer($playerName);
        $team = Team::firstOrNew(array('id' => $id));
        $team->name = $teamName;
        $team->player_id = $player->id;
        $team->save();
    }

    public function saveOrUpdatePlayer($name)
    {
        $player = Player::firstOrNew(array('name' => $name));
        $player->save();
        return $player;
    }
}
