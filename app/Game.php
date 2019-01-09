<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status', 'id_board'
    ];

    public function rulesets() {
        return $this->belongsToMany(Rule_Set::class, 'games_rule_sets', 'id_game', 'id_rule_set')
            ->withPivot('solved')
            ->withPivot('correct');
    }

    public function board() {
        return $this->belongsTo(Board::class, 'id_board');
    }

    public function options() {
        return $this->belongsToMany(Option::class, 'games_options', 'id_game', 'id_option')->withPivot('value');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
