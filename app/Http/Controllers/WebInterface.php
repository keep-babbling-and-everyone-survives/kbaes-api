<?php

namespace App\Http\Controllers;

use App\Events\GameStarted;
use App\Game;
use Illuminate\Http\Request;
use App\Events\RaspberryRequestNewGame;

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

    public function startGame(Request $request)
    {
        $game = new Game();
        $game->status = 'pending';
        $game->id_board = 1;
        //$game->id_board = $request->board_id;
        $game->save();

        event(new RaspberryRequestNewGame($game));

        return array('channel_id' => $game->id);
    }
}
