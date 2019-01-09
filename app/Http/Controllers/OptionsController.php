<?php

namespace App\Http\Controllers;

use App\Model\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = DB::table('options')->get();
        return view('admin.options.options', ['options' => $options]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.options.new-option');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $option = New Option();
        $option->name = $request->name;

        $option->save();
        return Redirect::to('/admin/options');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function show(Options $options)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function edit(Options $options)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Options $options)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Options  $options
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::table('options')->where('id', $id)->delete();
        return Redirect::to('/admin/options');
    }
}
