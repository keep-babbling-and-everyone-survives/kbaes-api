<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rule_Set extends Model
{
    protected $table = "rule_sets";

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'modules_rule_sets_solutions', 'id_rule_set', 'id_module')
            ->using(modules_rule_sets_solution::class)->withPivot('id_solution');
    }

    public function games() {
        return $this->belongsToMany(Game::class, 'games_rule_sets', 'id_rule_set', 'id_game')
            ->withPivot('solved')
            ->withPivot('correct');
    }

    /**
     * Return a count of modules needed for this ruleset execution on the board
     *
     * @return Array
     */
    public function modulesSummary() {
        $usedModules = $this->modules;
        $moduleCount = [];
        foreach($usedModules as $m) {
            if (array_key_exists($m->name, $moduleCount))
                $moduleCount[$m->name]++;
            else
                $moduleCount[$m->name] = 1;
        }

       return $moduleCount;
    }

    /**
     * Return modules as an array of name, values and solution for each member.
     *
     * @return Array
     */
    public function modulesAsArray() {
        $array = [];
        foreach ($this->modules as $m) {
            array_push($array, [
                "name" => $m->name,
                "is_analog" => $m->is_analog,
                "range_min" => $m->range_min,
                "range_max" => $m->range_max,
                "solution" => $m->pivot->solution->response
            ]);
        }
        return $array;
    }

    public function combinationToArray($len) {
        $combination = $this->combination;
        $output = [];
        for ($i = 0; $i < $len; $i++) {
            array_push($output, ($combination >> $i & 1));
        }
        return array_reverse($output);
    }
}
