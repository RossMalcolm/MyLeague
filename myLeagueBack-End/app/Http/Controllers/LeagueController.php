<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\League;
use App\Models\Team;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LeagueController extends Controller
{
    // POST login for admins
    public function login(Request $request){
        $bodyContent = json_decode($request->getContent(), true);

        $name = $bodyContent['league_name'];
        $password = $bodyContent['password'];;

        if (!isset($name) || !isset($password)) {
            return response(json_encode(["message" => "Missing required query parameter",]), 400);
        }

        $leagues = User::where('name', $name)
            ->where('password', md5($password))
            ->get();

        if (count($leagues) < 1) {
            return response(json_encode(["message" => "League name already taken",]), 400);
        }

        $leagueID = null;
        foreach ($leagues as $league) {
            $leagueID = $league->_league_id;
        }

        return response(json_encode(["league_id" => $leagueID]), 201);
    }


    //GET all leagues
    public function index() {
        // $leagues = League::get()->toJson(JSON_PRETTY_PRINT);

        $teamCountSelect = DB::table(TEAM::TABLE_NAME)
                            ->select(Team::LEAGUE_ID_COLUMN_NAME, DB::raw('count(*) as team_count'))
                            ->groupBy(Team::LEAGUE_ID_COLUMN_NAME);

        $leagues = DB::table(League::TABLE_NAME)
                    ->select(League::TABLE_NAME . '.*', DB::Raw('COALESCE( t.team_count , 0 ) as team_count'))
                    ->leftJoinSub($teamCountSelect, 't', function ($join) {
                        $join->on(League::TABLE_NAME . '.' . League::LEAGUE_ID_COLUMN_NAME, '=', 't.' . Team::LEAGUE_ID_COLUMN_NAME);
                    })->get()->toJson(JSON_PRETTY_PRINT);

        return response($leagues, 200);
    }


    // GET one league
    public function show($id=null){
        $league = League::where(League::LEAGUE_ID_COLUMN_NAME, $id)->first();

        //You can also use
        /* $league = League::find($id);*/        
        
        if ($league) {
            $league = $league->toJson(JSON_PRETTY_PRINT);
            return response($league, 200);
        }
        else {
            return response(json_encode(["message" => "League not found"]), 404);
        }
    }

    // POST create a league
    public function create(Request $request) {
        $bodyContent = json_decode($request->getContent(), true);
        
        $leagueName = $bodyContent['league_name'];
        $teamNames = $bodyContent['team_names'];
        $password = $bodyContent['password'];

        if (!isset($leagueName) || !isset($teamNames) || !isset($password)) {
            return response(json_encode(["message" => "Must supply 'league_id' and 'team_names'",]), 400);
        }

        $leagues = League::where(League::NAME_COLUMN_NAME, $leagueName)->get();

        if (count($leagues) > 0) {
            return response(json_encode(["message" => "League with given name exists already",]), 400);
        }

        $league = League::create([
            League::NAME_COLUMN_NAME => $leagueName
        ]);
        
        $league = $league->fresh();
        $leagueArray = json_decode($league, true);
        $leagueID = intval($leagueArray[League::LEAGUE_ID_COLUMN_NAME]);

        $insertArray = [
            '_league_id' => $leagueID,
            'name' => $leagueName,
            'password' => md5($password)
        ];

        DB::table('users')->insert($insertArray);

        $teams = explode(',', $teamNames);

        foreach ($teams as $team) {
            Team::create([
                Team::LEAGUE_ID_COLUMN_NAME => $leagueID,
                Team::NAME_COLUMN_NAME => $team
            ]);
        }

        return response(json_encode(["league_id" => $leagueID,]), 201);
    }

    // POST create game
    public function createGame(Request $request) {
        $bodyContent = json_decode($request->getContent(), true);
        

        //required
        if (!isset($bodyContent['league_id']) || !isset($bodyContent['home_team_id']) || !isset($bodyContent['away_team_id']) || !isset($bodyContent['date']) || !isset($bodyContent['played'])) {
            return response(json_encode(["message" => "Missing required post body parameter"]), 400);
        }
        
        $insertArray = [
            Game::LEAGUE_ID_COLUMN_NAME => intval($bodyContent['league_id']),
            Game::PLAYED_COLUMN_NAME => $bodyContent['played'],
            Game::DATE_COLUMN_NAME => $bodyContent['date'],
            Game::HOME_TEAM_ID_COLUMN_NAME => intval($bodyContent['home_team_id']),
            Game::AWAY_TEAM_ID_COLUMN_NAME => intval($bodyContent['away_team_id']),
        ];
        
        //optional but all need to be given
        if (isset($bodyContent['home_goals']) || isset($bodyContent['away_goals']) || isset($bodyContent['OT'])) {
            if (!isset($bodyContent['home_goals']) || !isset($bodyContent['away_goals']) || !isset($bodyContent['OT'])) {
                return response(json_encode(["message" => "Must supply all optional parameter when one is given"]), 400);
            }

            $insertArray[Game::HOME_GOALS_COLUMN_NAME] = intval($bodyContent['home_goals']);
            $insertArray[Game::AWAY_GOALS_COLUMN_NAME] = intval($bodyContent['away_goals']);
            $insertArray[Game::OT_COLUMN_NAME] = $bodyContent['OT'];
        }

        DB::table(Game::TABLE_NAME)->insert($insertArray);

        return response(json_encode(["message" => "Game created",]), 201);
    }


    // POST update game
    public function updateGame(Request $request) {
        $bodyContent = json_decode($request->getContent(), true);

        if (!isset($bodyContent['game_id'])) {
            return response(json_encode(["message" => "Missing required post body parameter"]), 400);
        }

        if (!isset($bodyContent['home_goals']) && !isset($bodyContent['away_goals']) && !isset($bodyContent['date']) && !isset($bodyContent['OT'])) {
            return response(json_encode(["message" => "Missing required post body parameter"]), 400);
        }

        $response = [];

        $game = Game::find($bodyContent['game_id']);

        if (isset($bodyContent['home_goals'])) {
            $game->home_goals = intval($bodyContent['home_goals']);
        }

        if (isset($bodyContent['away_goals'])) {
            $game->away_goals = intval($bodyContent['away_goals']);
        }

        if (isset($bodyContent['date'])) {
            $game->date = $bodyContent['date'];
        }

        if (isset($bodyContent['OT'])) {
            $game->date = $bodyContent['OT'];
        }

        $game->save();

        $game = Game::where(Game::GAME_ID_COLUMN_NAME, $bodyContent['game_id'])->first()->toJson(JSON_PRETTY_PRINT);

        
        return response($game, 200);
    }

    // GET get schedule for league
    public function schedule(Request $request) {
        $leagueID = null;
        $date = null;
        $date2 = null;

        if (!$request->has('league_id')) {
            return response(json_encode(["message" => "Missing required query parameter"]), 400);
        }

        if ($request->has('upcomming') && $request->input('upcomming')) {
            $date = date("Y-m-d H:i:s");
        }
        elseif ($request->has('upcomming') && !$request->input('upcomming')) {
            $date2 = date("Y-m-d H:i:s");
        }

        $leagueID = $request->input('league_id');

        $games = DB::table(Game::TABLE_NAME)
                    ->where(Game::LEAGUE_ID_COLUMN_NAME, $leagueID)
                    ->when($date, function ($query, $date) {
                        return $query->where('date', '>', $date);
                    })
                    ->when($date2, function ($query, $date2) {
                        return $query->where('date', '<', $date2);
                    })
                    ->orderBy('date', 'asc')
                    ->get()->toJson(JSON_PRETTY_PRINT);

        

        return response($games, 200);
    }


    // GET leaderboard
    public function leaderboard(Request $request) {
        $leagueID = null;
        $response = [];


        if (!$request->has('league_id')) {
            return response(json_encode(["message" => "Missing required query parameter"]), 400);
        }

        $leagueID = $request->input('league_id');

        $teams = Team::where(Team::LEAGUE_ID_COLUMN_NAME, $leagueID)->get();

        foreach ($teams as $team) {
            
            $teamID = $team->team_id;
            $wins = 0;
            $loss = 0;
            $OTloss = 0;

            $goals = 0;

            $games = Game::where(Game::HOME_TEAM_ID_COLUMN_NAME, $teamID)
                            ->orWhere(Game::AWAY_TEAM_ID_COLUMN_NAME, $teamID)
                            ->get();

            foreach ($games as $game) {
                if ($game->home_team_id == $teamID) {
                    $wins = $game->home_goals > $game->away_goals ? $wins + 1 : $wins;
                    $loss = $game->home_goals < $game->away_goals ? $loss + 1 : $loss;
                    $OTloss = $game->home_goals < $game->away_goals && $game->OT == true ? $OTloss + 1 : $OTloss;

                    $goals = 0;
                }
                else {
                    $wins = $game->away_goals > $game->home_goals ? $wins + 1 : $wins;
                    $loss = $game->away_goals < $game->home_goals ? $loss + 1 : $loss;
                    $OTloss = $game->away_goals < $game->home_goals && $game->OT == true ? $OTloss + 1 : $OTloss;

                    $goals = 0;
                }
            }

            $points = $wins * 2 + $OTloss;

            $response[] = [
                'team_id' => $teamID,
                'team_name' => $team->name,
                'wins' => $wins,
                'loss' => $loss,
                'OT_loss' => $OTloss,
                'points' => $points
            ];

        }

        // Sort
        $pointsC  = array_column($response, 'points');
        $winsC = array_column($response, 'wins');
        array_multisort($pointsC, SORT_DESC, $winsC, SORT_DESC, $response);

        return response(json_encode($response), 200);

    }

    // GET stats
    public function stats(Request $request) {
        $leagueID = null;
        $response = [];


        if (!$request->has('league_id')) {
            return response(json_encode(["message" => "Missing required query parameter"]), 400);
        }

        $leagueID = $request->input('league_id');

        $teams = Team::where(Team::LEAGUE_ID_COLUMN_NAME, $leagueID)->get();

        foreach ($teams as $team) {
            
            $teamID = $team->team_id;
            $wins = 0;
            $loss = 0;
            $OTloss = 0;

            $goals = 0;
            $homeGoals = 0;
            $awayGoals = 0;
            
            $goalsCon = 0;
            $homeGoalCon = 0;
            $awayGoalsCon = 0;

            $games = Game::where(Game::HOME_TEAM_ID_COLUMN_NAME, $teamID)
                            ->orWhere(Game::AWAY_TEAM_ID_COLUMN_NAME, $teamID)
                            ->get();

            foreach ($games as $game) {
                if ($game->home_team_id == $teamID) {
                    $wins = $game->home_goals > $game->away_goals ? $wins + 1 : $wins;
                    $loss = $game->home_goals < $game->away_goals ? $loss + 1 : $loss;
                    $OTloss = $game->home_goals < $game->away_goals && $game->OT == true ? $OTloss + 1 : $OTloss;

                    $goals += $game->home_goals;
                    $homeGoals += $game->home_goals;

                    $goalsCon += $game->away_goals;
                    $homeGoalCon += $game->away_goals;
                }
                else {
                    $wins = $game->away_goals > $game->home_goals ? $wins + 1 : $wins;
                    $loss = $game->away_goals < $game->home_goals ? $loss + 1 : $loss;
                    $OTloss = $game->away_goals < $game->home_goals && $game->OT == true ? $OTloss + 1 : $OTloss;

                    $goals += $game->away_goals;
                    $awayGoals += $game->away_goals;

                    $goalsCon += $game->home_goals;
                    $awayGoalsCon += $game->home_goals;
                }
            }

            ini_set("precision", 2);

            $response[] = [
                'team_id' => $teamID,
                'team_name' => $team->name,
                'games' => $wins + $loss,
                'win_percentage' => ($wins + $loss) > 0 ? (((float) $wins / (float) ($wins + $loss)) * 100): 0,
                'avg_goals_scored_per_game' => ($wins + $loss) > 0 ? ($goals / (float) ($wins + $loss)) : 0,
                'avg_goals_conceded_per_game' => ($wins + $loss) > 0 ? ($goalsCon / (float) ($wins + $loss)) : 0,
                'goals_scored' => $goals,
                'home_goals_scored' => $homeGoals,
                'away_goals_scored' => $awayGoals,
                'goals_conceded' => $goalsCon,
                'home_goals_conceded' => $homeGoalCon,
                'away_goals_conceded' => $awayGoalsCon,
            ];

        }

        // Sort
        $sort1 = array_column($response, 'team_id');
        $sort2 = array_column($response, 'team_name');
        array_multisort($sort1, SORT_ASC, $sort2, SORT_ASC, $response);

        return response(json_encode($response), 200);

    }

}
