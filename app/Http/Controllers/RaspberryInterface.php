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
    private $gameLogics = new GameCourseBO;

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

        $updateStatus = $this->gameLogics->confirmGame($game);

        return response()->json($updateStatus["response"], $updateStatus["status"]);
    }
}
