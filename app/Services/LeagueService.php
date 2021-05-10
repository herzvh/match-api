<?php


namespace App\Services;


use App\Models\League;

class LeagueService
{
    public function saveOrUpdateLeague($id, $name)
    {
        $league = League::firstOrNew(array('id' => $id));
        $league->name = $name;
        $league->save();
        return $league;
    }

}
