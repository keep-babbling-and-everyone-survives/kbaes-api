<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule_Set extends Model
{
    protected $table = "rule_sets";

    public function module()
    {
        return $this->belongsToMany('App\Module', 'modules_rule_sets_solutions', 'id_rule_set', 'id_module')
            ->using('App\modules_rule_sets_solution')->withPivot('id_solution');
    }

    public function games() {
        return $this->belongsToMany(Game::class, 'games_rule_sets', 'id_rule_set', 'id_game');
    }
}
