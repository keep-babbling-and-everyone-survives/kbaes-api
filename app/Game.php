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

    protected $table = "game";
}
