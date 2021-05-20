<?php


namespace App\Repository;


use Illuminate\Support\Facades\DB;

class EloquentMatch implements MatchRepository
{

    public function getAllMatches()
    {
        return DB::select(DB::raw('
                select m.id, m.status , l2.id as league_id, l2.name as league , m.round , m.timer, m.type , m.date , m.time, t.name,
                    concat(\'[\', group_concat(distinct concat(
                                        \'{ "period": {\',
                                            \'"name":"\', s.period_name , \'",\' ,
                                            \'"visitorteam":\', s.visitorteam_score , \',\' ,
                                            \'"localteam":\', s.localteam_score,
                                        \'} }\')),
							\']\') as scoreboard ,
					group_concat(
					    distinct (
                            case
                                when mt.`type` = \'localteam\' then
                                     concat(\'{\',
                                                \'"id":"\', t.id , \'",\',
                                                \'"name":"\', t.name ,\'(\', p.name ,\')\', \'",\' ,
                                                \'"score":\', mt.score ,
                                            \'}\')
                                else null
                            end
					    )
                    ) as localteam ,
					group_concat(
					    distinct (
                            case
                                when mt.`type` = \'awayteam\' then
                                     concat(\'{\',
                                                \'"id":"\', t.id , \'",\' ,
                                                \'"name":"\', t.name ,\'(\', p.name ,\')\', \'",\' ,
                                                \'"score":\', mt.score ,
                                            \'}\')
                                else null
                            end
                        )
					) as awayteam
                    from matches m
                    left join leagues l2 on l2.id = m.league_id
                    left join scoreboards s on s.match_id = m.id
                    left join matches_teams mt on mt.match_id = m.id
                    left join teams t on t.id = mt.team_id
                    inner join players p on p.id = t.player_id
                    group by m.id
            '));
    }
}
