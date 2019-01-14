<?php

namespace App\Http\Controllers;

use App\Model\Game;
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
}
