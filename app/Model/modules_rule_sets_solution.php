<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class modules_rule_sets_solution extends Pivot
{
    protected $table="modules_rule_sets_solutions";

    public function module() {
        return $this->belongsTo('App\Module', 'id_module', 'id');
    }

    public function solution() {
        return $this->belongsTo('App\Solution', 'id_solution', 'id');
    }

    public function ruleset() {
        return $this->belongsTo('App\Rule_Set', 'id_rule_set', 'id');
    }
}
