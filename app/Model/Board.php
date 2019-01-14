<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function games() {
        return $this->hasMany(Game::class, 'id_board');
    }

    public function modules() {
        return $this->belongsToMany(Module::class, 'boards_modules', 'id_board', 'id_module');
    }
}
