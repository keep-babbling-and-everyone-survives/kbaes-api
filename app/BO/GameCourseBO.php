<?php

namespace App\BO;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Events\Website\GameUpdate;
use App\Events\Website\GameCreatedSuccess;
use App\Events\Raspberry\RequestNewGame;
use App\Events\Raspberry\RequestGameHalt;
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
            if ($game->status === 'pending')
                event(new RequestNewGame($game));
        } else if (count($game) === 0) {
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

    /**
     * Performs game confirmation and provide the next ruleset to be played by the board or an error code
     *
     * @param Game $game
     * @return Rule_Set
     */
    public function confirmGame(Game $game)
    {
        $game->status = "running";
        $game->save();

        event(new GameCreatedSuccess($game));

        return $game->rulesets[0];
    }

    public function abortGame(Game &$game) {
        $game->status = "aborted";
        $game->save();

        event(new RequestGameHalt($game));
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
            $offset = rand(0, count($availableRuleSets)-1);
            $generated = $availableRuleSets[$offset];
            while (in_array($generated, $chosenRuleSets)) {
                $offset = rand(0, count($availableRuleSets)-1);
                $generated = $availableRuleSets[$offset];
            }
            array_push($chosenRuleSets, $generated);
            $game->rulesets()->attach($generated, ["solved" => false, "correct" => false,]);
        }
    }

    public function answerRuleset(Game &$game, $rsid, $answer) {
        $currentRuleset = $game->rulesets()->where('id_rule_set', $rsid)->first();
        $expectedSolution = array_map(function($a) { return ['name' => $a['name'], 'solution' => $a['solution']];}, $currentRuleset->modulesAsArray());

        $rsIsCorrect = true;
        for($i = 0; $i < count($expectedSolution); $i++) {
            if (count(array_diff($expectedSolution[$i], $answer[$i])) !== 0) {
                $rsIsCorrect = false;
            }
        }

        $game->rulesets()->updateExistingPivot($rsid, ["solved" => true, "correct" => $rsIsCorrect]);
        
        $nextRuleset = $game->rulesets()->where('solved', false)->first();

        $hasNext = true;
        if (is_null($nextRuleset)) {
            $hasNext = false;
            $game->status = "finished";
            $game->save();
        }

        $update = [
            "type" => "answer",
            "answer" => $rsIsCorrect,
            "hasNext" => $hasNext,
        ];

        event(new GameUpdate($game, $update));

        return $hasNext ? $nextRuleset : null;
    }
}