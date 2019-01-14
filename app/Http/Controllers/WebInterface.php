<?php

namespace App\Http\Controllers;

use App\Model\Game;
use App\Model\Rule_Set;
use Illuminate\Http\Request;
use App\Events\Raspberry\RequestNewGame;
use Illuminate\Support\Facades\Auth;
use App\Events\Website\GameCreatedSuccess;
use App\BO\GameCourseBO;

class WebInterface extends Controller
{

    /**
     * @var GameCourseBO
     */
    private $gameLogics;
    
    public function __construct() {
        $this->gameLogics = new GameCourseBO;
    }

    // POST /api/game/start
    public function startGame(Request $request)
    {
        $launchResult = $this->gameLogics->startGame(1, $request->game_options);

        return response()->json($launchResult["response"], $launchResult["status"]);
    }

    public function getRuleSets($id) {
        $game = Game::find($id);
        $rulesets = Rule_Set::All();
        $availableRuleSets = [];
        $availableRuleSets['rule_sets'] = array();
        foreach($rulesets as $rs) {
            $rsIsAvailable = false;
            foreach($rs->modules as $module) {
                foreach($module->boards as $board) {
                    if ($board->id === $game->id_board) {
                        $rsIsAvailable = true;
                    }
                }
                if ($rsIsAvailable) {
                    $availableRuleSets['rule_sets']['rule_set_' . $rs->id] = array('combination' => $rs->combination, 'module' => $rs->modulesAsArray());

                }
            }

        }
        return response()->json($availableRuleSets, 200);
    }

    // GET /api/game/{id}/abort
    public function abortGame($id) {
        $game = Game::findOrFail($id);

        $this->gameLogics->abortGame($game);

    }
}


//"modules": [{"name": "button", "solution": "1"},{"name": "button", "solution": "0"},{"name": "button", "solution": "1"}]


//[{"id":1,"created_at":"2019-01-09 14:57:29","updated_at":"2019-01-09 14:57:29","combination":13,
//"modules":[{"id":1,"created_at":"2019-01-09 14:55:49","updated_at":"2019-01-09 14:55:49","name":"button","is_analog":1,"range_min":null,"range_max":null,"pivot":{"id_rule_set":1,"id_module":1,"id_solution":1},
//"boards":[{"id":1,"created_at":"2019-01-09 14:46:54","updated_at":"2019-01-09 14:46:54",
//"pivot":{"id_module":1,"id_board":1}}]}