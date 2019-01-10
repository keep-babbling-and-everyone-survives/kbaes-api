<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class modules_rule_sets_solution extends Pivot
{
    protected $table="modules_rule_sets_solutions";

    public function module() {
        return $this->belongsTo(Module::class, 'id_module', 'id');
    }

    public function solution() {
        return $this->belongsTo(Solution::class, 'id_solution', 'id');
    }

    public function ruleset() {
        return $this->belongsTo(Rule_Set::class, 'id_rule_set', 'id');
    }
}
