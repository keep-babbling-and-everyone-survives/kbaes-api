<?php

namespace App\Http\Controllers;

use App\Model\Board;
use App\Events\WebIGameCreatedSuccess;
use App\Model\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = DB::table('games')
            ->leftJoin('games_rule_sets AS grs', 'games.id', '=', 'grs.id_game')
            ->leftJoin('rule_sets AS rs', 'grs.id_rule_set', '=', 'rs.id')
            ->select('games.*', 'rs.combination')
            ->get();

        return view('admin.games.games', ['games' => $games]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $game = new Game();
        $game->status = 'pending';
        //$game->id_board = $request->board_id;
        $game->save();

        return array('channel_id' =>$game->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('games')->where('id', $id)->delete();
        return Redirect::to('/admin/games');
    }
}
