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
        $boardId = 1;
        $httpCode = 0;
        $response = [];

        $game = Game::where('id_board', $boardId)
            ->where('status', 'like', 'pending')
            ->orWhere('status', 'like', 'running')
            ->get();

        if (count($game) == 1) {
            $game = $game[0];
            $response["channel_id"] = $game->id;
            $response["status"] = $game->status;
            $httpCode = 200;
            event(new RaspberryRequestNewGame($game));
        } else if (count($game) == 0) {
            $game = new Game();
            $game->status = 'pending';
            $game->id_board = $boardId;
            $game->save();

            $httpCode = 201;
            $response["channel_id"] = $game->id;
            $response["status"] = $game->status;
            event(new RaspberryRequestNewGame($game));
        } else {
            $httpCode = 409;
            $response = [
                "Error" => "More than one game requested or running on the same board. Check your games and reset your board before trying again.",
            ];
        }

        return response()->json($response, $httpCode);
    }
}
