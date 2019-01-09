<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{
    public function rulesets() {
        return $this->belongsToMany(Rule_Set::class, 'modules_rule_sets_solutions', 'id_solution', 'id_rule_set')
            ->using(modules_rule_sets_solution::class)->withPivot('id_module');
    }

    public function module() {
        return $this->hasOne(Module::class);
    }
}
