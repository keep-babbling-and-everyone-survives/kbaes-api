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
}
