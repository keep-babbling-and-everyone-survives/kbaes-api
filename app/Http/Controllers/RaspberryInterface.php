<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\Website\GameCreatedSuccess;
use App\Events\Website\GameUpdate;
use App\Events\Raspberry\GameUpdate as RaspberryGameUpdate;
use App\Model\Game;
use App\Model\Rule_Set;
use App\Model\Board;
use App\Model\Module;

class RaspberryInterface extends Controller
{
    // Route : /api/game/confirm/{id}
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

        if ($game->status !== "pending") {
            return response()->json([
                "error" => "You can't confirm a running game."
            ], 409);
        }

        $game->status = "running";
        $game->save();

        event(new GameCreatedSuccess($game));

        $this->initRuleSets($game);
        $nextRuleset = $game->rulesets[0];

        event(new RaspberryGameUpdate($game, $nextRuleset));
    }

    private function initRuleSets(Game $game) {
        $nofmodules = 2; // $game->options[modules]

        $rulesets = Rule_Set::All();
        $availableRuleSets = [];
        foreach($rulesets as $rs) {
            $rsIsAvailable = false;
            foreach($rs->modules as $module) {
                foreach($module->boards as $board) {
                    if ($board->id === $game->id_board)
                        $rsIsAvailable = true;
                }
            }

            if ($rsIsAvailable)
                array_push($availableRuleSets, $rs);
        }

        unset($rulesets);

        if (count($availableRuleSets) < $nofmodules) {
            $nofmodules = count($availableRuleSets);
        }

        $chosenRuleSets = [];
        for($i = 0; $i < $nofmodules; $i++) {
            $generated = $availableRuleSets[rand(0, count($availableRuleSets))];
            while (in_array($generated, $chosenRuleSets)) {
                $generated = $availableRuleSets[rand(0, count($availableRuleSets))];
            }
            array_push($chosenRuleSets, $generated);
            $game->rulesets()->attach($generated, ["solved" => false, "correct" => false,]);
        }
    }
}
