<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function games() {
        return $this->hasMany(Game::class, 'id_board');
    }
}
