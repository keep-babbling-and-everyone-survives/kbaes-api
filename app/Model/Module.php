<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public function boards() {
        return $this->belongsToMany(Board::class, 'boards_modules', 'id_module', 'id_board');
    }

    public function rulesets() {
        return $this->belongsToMany(Rule_Set::class, 'modules_rule_sets_solutions', 'id_module', 'id_rule_set')
            ->using(modules_rule_sets_solution::class)->withPivot('id_solution');
    }
}
