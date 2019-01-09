<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class m_cc_s extends Pivot
{
    protected $table = "m_cc_s";

    public function module() {
        return $this->hasOne('App\Module', 'id_module', 'id');
    }

    public function solution() {
        return $this->hasOne('App\Solution', 'id_solution', 'id');
    }

    public function ruleset() {
        return $this->hasOne('App\Rule_Set', 'id_rule_set', 'id');
    }
}
