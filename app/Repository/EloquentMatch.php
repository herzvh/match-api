<?php


namespace App\Repository;


use Illuminate\Support\Facades\DB;

class EloquentMatch implements MatchRepository
{

    public function getAllMatches()
    {
        return DB::select(DB::raw('
            select m.id, m.status , l2.name , m.round , m.type , m.date , m.time,
                    concat(\'[\', group_concat(concat(
                                        \'{\',
                                            \'"period":"\', s.period_name , \'",\' ,
                                            \'"visitorscore":\', s.visitorteam_score , \',\' ,
                                            \'"localscore":\', s.localteam_score,
                                        \'}\')), \']\') as period_score ,

                    concat(\'[\', group_concat(concat(
                                        \'{\',
                                            \'"team_name":"\', t.name , \'",\' ,
                                            \'"player":"\', p.name , \'",\' ,
                                            \'"score":"\', mt.score , \'",\' ,
                                            \'"type":"\', mt.type ,
                                        \'}\')), \']\') as teams_vs
                    from matches m
                    left join leagues l2 on l2.id = m.league_id
                    left join scoreboards s on s.match_id = m.id
                    left join matches_teams mt on mt.match_id = m.id
                    left join teams t on t.id = mt.team_id
                    inner join players p on p.id = t.player_id
                    group by m.id , m.status , l2.name , m.round , m.type , m.date , m.time
            '));
    }
}
