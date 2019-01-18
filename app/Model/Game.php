<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Predis\Configuration\Options;

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

    public function getOptionsAsArray() {
        $options = [];
        foreach($this->options as $o) {
            $options[$o->name] = $o->pivot->value;
        }

        return $options;
    }

    /**
     * Attach the required option with set value
     *
     * @param [String] $name
     * @param [String] $value
     * @throw [ModelNotFoundException] the $name is not present in the options table
     */
    public function setOption($name, $value) {
        $option = Option::where('name', $name)->firstOrFail();
        $hasValue = $this->options()->where('name', $name)->count();

        if ($hasValue > 0) {
            $this->options()->updateExistingPivot($option->id, ['value' => strval($value)]);
        } else {
            $this->options()->attach($option->id, ['value' => strval($value)]);
        }
    }
}
