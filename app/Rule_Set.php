<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rule_Set extends Model
{
    protected $table = "rule_set";

    public function module()
    {
        return this->belongsToMany('App\Module', 'm_cc_s', 'id_rule_set', 'id_module')->withpivot('App\m_cc_s', 'solution');
    }
}
