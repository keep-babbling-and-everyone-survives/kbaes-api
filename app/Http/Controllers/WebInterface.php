<?php

namespace App\Http\Controllers;

use App\Events\GameStarted;
use Illuminate\Http\Request;

class WebInterface extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function startGame($game)
    {
        event(new GameStarted($game));
    }
}
