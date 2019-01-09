<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function games() {
        return $this->belongsToMany(Game::class, 'games_options', 'id_option', 'id_game')->withPivot('value');
    }
}
