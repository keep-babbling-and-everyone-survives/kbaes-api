<?php

namespace App\BO;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\Website\GameUpdate;
use App\Events\Website\GameCreatedSuccess;
use App\Events\Raspberry\RequestNewGame;
use App\Events\Raspberry\GameUpdate as RaspberryGameUpdate;
use App\Model\Game;
use App\Model\Rule_Set;
use App\Model\Board;
use App\Model\Module;

class GameCourseBO {

    public function startGame($boardId = 1, $options = [])
    {
        $boardId = 1;
        $response = [];
        if (!isset($options['time']))
            $options['time'] = "180";
        if (!isset($options['modules']))
            $options['modules'] = 3;

        $game = Game::where('id_board', $boardId)
            ->where('status', 'like', 'pending')
            ->orWhere('status', 'like', 'running')
            ->get();

        if (count($game) === 1) {
            $game = $game[0];
            $response["channel_id"] = $game->id;
            $response["status"] = $game->status;
            $response["options"] = $game->getOptionsAsArray();
            $httpCode = 200;
            event(new RequestNewGame($game));
        } else if (count($game) == 0) {
            $game = new Game();
            $game->user()->associate(Auth::user());
            $game->status = 'pending';
            $game->id_board = $boardId;
            $game->save();

            foreach($options as $key => $value) {
                $game->setOption($key, $value);
            }

            $this->initRuleSets($game);

            $httpCode = 201;
            $response["channel_id"] = $game->id;
            $response["status"] = $game->status;
            $response["options"] = Game::find($game->id)->getOptionsAsArray();
            event(new RequestNewGame($game));
        } else {
            $httpCode = 409;
            $response = [
                "Error" => "More than one game requested or running on the same board. Check your games and reset your board before trying again.",
            ];
        }

        return ["response" => $response, "status" => $httpCode];
    }

    public function confirmGame(Game $game)
    {
        if ($game->status !== "pending") {
            return [
                "response" => [ "error" => "You can't confirm an already running game.", ],
                "status" => 409
            ];
        }

        $game->status = "running";
        $game->save();

        event(new GameCreatedSuccess($game));

        $nextRuleset = $game->rulesets[0];

        event(new RaspberryGameUpdate($game, $nextRuleset));

        return [
            "response" => [ "channel_id" => $game->id, "status" => $game->status ],
            "status" => 200
        ];
    }

    private function initRuleSets(Game &$game) {
        $nofRulesets = $game->getOptionsAsArray()['modules'];

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

        if (count($availableRuleSets) < $nofRulesets) {
            $nofRulesets = count($availableRuleSets);
            $game->setOption('modules', count($availableRuleSets));
        }

        $chosenRuleSets = [];
        for($i = 0; $i < $nofRulesets; $i++) {
            $generated = $availableRuleSets[rand(0, count($availableRuleSets)-1)];
            while (in_array($generated, $chosenRuleSets)) {
                $generated = $availableRuleSets[rand(0, count($availableRuleSets))];
            }
            array_push($chosenRuleSets, $generated);
            $game->rulesets()->attach($generated, ["solved" => false, "correct" => false,]);
        }
    }
}