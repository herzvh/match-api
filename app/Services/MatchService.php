<?php


namespace App\Services;


use App\Models\Match;
use App\Models\MatchTeam;
use App\Models\Scoreboard;
use App\Repository\MatchRepository;

class MatchService
{
    protected $leagueService;
    protected $teamService;
    protected $scoreboardService;
    /**
     * @var MatchRepository
     */
    private $matchRepository;

    public function __construct(LeagueService $leagueService, TeamService $teamService, ScoreboardService $scoreboardService, MatchRepository $matchRepository)
    {
        $this->leagueService = $leagueService;
        $this->teamService = $teamService;
        $this->scoreboardService = $scoreboardService;
        $this->matchRepository = $matchRepository;
    }

    public function getAll()
    {
        return $this->matchRepository->getAllMatches();
    }

    public function saveOrUpdateMatch($matches)
    {
        foreach ($matches as $match) {
            $matchAttr = $match['@attributes'];
            $this->leagueService->saveOrUpdateLeague($matchAttr['league_id'], $matchAttr['league']);
            $foundMatch = Match::firstOrNew(['id' => $matchAttr['id']]);
            $foundMatch->status = $matchAttr['status'];
            $foundMatch->round = $matchAttr['round'];
            $foundMatch->type = $matchAttr['type'];
            $foundMatch->timer = $matchAttr['timer'];
            $foundMatch->date = $matchAttr['date'];
            $foundMatch->time = $matchAttr['time'];
            $foundMatch->league_id = $matchAttr['league_id'];
            $foundMatch->save();

            $this->saveTeam($match, 'localteam');
            $this->saveTeam($match, 'awayteam');
            $this->saveTeamMatch($match, 'localteam');
            $this->saveTeamMatch($match, 'awayteam');

            $scoreboardP = $match['scoreboard'];
            if(isset($scoreboardP) && !empty($scoreboardP) && isset($scoreboardP['period']) && !empty($scoreboardP['period'])) {
                $periods = $scoreboardP['period'];
                $this->scoreboardService->saveOrUpdateScoreboard($matchAttr['id'], $periods);
            }
        }
    }

    private function saveTeam($match, $teamKey)
    {
        if (isset($match[$teamKey])) {
            $tmp = $match[$teamKey];
            $team = $tmp['@attributes'];
            $this->teamService->saveOrUpdateTeam($team['id'], $team['name']);
        }
    }

    private function saveTeamMatch($match, $teamKey)
    {
        if (isset($match[$teamKey])) {
            $tmp = $match[$teamKey];
            $team = $tmp['@attributes'];
            $matchAttr = $match['@attributes'];

            $matchTeam = MatchTeam::firstOrNew(array('match_id' => $matchAttr['id'], 'team_id' => $team['id']));
            $matchTeam->score = isset($team['score']) && !empty($team['score']) ? $team['score'] : 0;
            $matchTeam->type = $teamKey;
            $matchTeam->match_id = $matchAttr['id'];
            $matchTeam->team_id = $team['id'];
            $matchTeam->save();
        }
    }
}
