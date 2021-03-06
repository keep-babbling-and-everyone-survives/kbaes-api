<?php

namespace App\Http\Controllers;

use App\Model\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boards = Board::All();
        foreach($boards as $board) {
            $board['modules'] = DB::table('boards_modules AS bm')->where('bm.id_board', $board['id'])->leftJoin('modules AS m', 'bm.id_module', '=', 'm.id')->get();
        }
        return view('admin.boards.boards', ['boards' => $boards]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $board = new Board;
        $board->created_at = now();
        $board->save();
        $boards = DB::table('boards')->get();
        return view('admin.boards.boards', ['boards' => $boards]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $board = DB::table('boards')->where('id', $id)->first();
        return view('admin.boards.board', ['boards' => $board]);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Board::destroy($id);
        return Redirect::to('/admin/boards');
    }
}
