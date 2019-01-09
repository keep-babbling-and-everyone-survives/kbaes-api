<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Game;
use App\Events\Website\GameCreatedSuccess;
use App\Events\Website\GameUpdate;
use App\Events\Raspberry\GameUpdate as RaspberryGameUpdate;
use App\Rule_Set;

class RaspberryInterface extends Controller
{
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

        $game->status = "running";
        $game->save();

        event(new GameCreatedSuccess($game));

        $nextRuleset = $this->initRuleSet();
        event(new RaspberryGameUpdate($game, $nextRuleset));
        event(new GameUpdate($game, $nextRuleset));
    }

    private function initRuleSet() {
        return new Rule_Set();
    }
}
