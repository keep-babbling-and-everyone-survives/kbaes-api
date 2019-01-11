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
}
