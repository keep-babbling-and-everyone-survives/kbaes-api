<?php

namespace App\Http\Controllers;

use App\Events\GameStarted;
use App\Game;
use Illuminate\Http\Request;

class WebInterface extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function startGame($game)
    {
        $new_game = new Game();
        event(new GameStarted($new_game));
    }

    public function startGameStatic()
    {
        event(new GameStarted(1));
    }
}
