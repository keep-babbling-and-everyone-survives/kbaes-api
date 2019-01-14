<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\BO\GameCourseBO;
use App\Events\Website\GameCreatedSuccess;
use App\Events\Website\GameUpdate;
use App\Events\Raspberry\GameUpdate as RaspberryGameUpdate;
use App\Model\Game;
use App\Model\Rule_Set;
use App\Model\Board;
use App\Model\Module;

class RaspberryInterface extends Controller
{
    /**
     * @var GameCourseBO
     */
    private $gameLogics;

    public function __construct() {
        $this->gameLogics = new GameCourseBO;
    }

    // Route : /api/game/{id}/confirm
    public function confirmGame(Request $req, $id)
    {
        try {
            $game = Game::findOrFail($id);
        }
        catch (ModelNotFoundException $ex) {
            return response()->json([
                "error" => "The requested game does not exists. Check your admin panel."
            ], 404);
        }
        
        if ($game->status === "pending") {
            $confirmation = $req->status;

            if ($confirmation === 'OK') {
                $nextRuleset = $this->gameLogics->confirmGame($game);
                $updateStatus = [ "response" => [
                    "game_id" => $game->id,
                    "game_status" => $game->status,
                    "next_ruleset" => [
                        "id" => $nextRuleset->id,
                        "combination" => $nextRuleset->combination,
                        "modules" => $nextRuleset->modulesAsArray(),
                    ],
                ], "status" => 200 ];
            } else if ($confirmation === 'KO') {
                $game->status = "aborted";
                $game->save();
                $updateStatus["response"]["status"] = 200;
            } else {
                // Something went wrong
                $updateStatus = [
                    "response" => [ "error" => "Please provide a confirmation status"],
                    "status" => 400
                ];
            }
        } else {
            $updateStatus = [
                "response" => [ "error" => "You can't confirm a game when it's not waiting for confirmation.", ],
                "status" => 409
            ];
        }

        return response()->json($updateStatus["response"], $updateStatus["status"]);
    }

    // POST /api/game/{gameid}/answer/{rsid}
    public function answerRuleset(Request $req, $gameid, $rsid) {
        try {
            $game = Game::findOrFail($gameid);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                "error" => "The requested game does not exists. Check your admin panel."
            ], 404);
        }

        $updateStatus = [];

        $nextRuleset = $this->gameLogics->answerRuleset($game, $rsid, $req->modules);
        $isCorrect = $game->rulesets()->where('id_rule_set', $rsid)->first()->pivot->correct;

        if (!is_null($nextRuleset)) {
            $updateStatus = [
                "response" => [
                    "solved" => $isCorrect,
                    "has_next" => true,
                    "game_id" => $game->id,
                    "game_status" => "running",
                    "next_ruleset" => [
                        "id" => $nextRuleset->id,
                        "combination" => $nextRuleset->combination,
                        "modules" => $nextRuleset->modulesAsArray(),
                    ],
                ],
                "status" => 200,
            ];
        } else {
            $updateStatus = [
                "response" => [
                    "solved" => $isCorrect,
                    "has_next" => false,
                    "game_id" => $game->id,
                    "game_status" => "finished",
                    "next_ruleset" => [],
                ],
                "status" => 200,
            ];
        }

        return response()->json($updateStatus["response"], $updateStatus["status"]);
    }

    // GET /api/game/{id}/current
    public function requestCurrentRuleset($id) {
        try {
            $game = Game::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                "error" => "The requested game does not exists. Check your admin panel."
            ], 404);
        }

        if ($game->status !== 'running') {
            return response()->json([
                "error" => "This game is not running. ($game->status)"
            ], 409);
        }

        $c = $game->rulesets[0];
        $currentRuleset = [
            "id" => $c->id,
            "combination" => $c->combination,
            "modules" => $c->modulesAsArray(),
        ];

        return response()->json([$currentRuleset], 200);
    }
}
