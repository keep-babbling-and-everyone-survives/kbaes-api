<?php

namespace App\Http\Controllers;

use App\Rule_Set;
use Illuminate\Http\Request;

class RuleSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $combination)
    {
        $rule_set = New Rule_Set();
        $rule_set->combination = $combination;

        $rule_set->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rule_Set  $rule_Set
     * @return \Illuminate\Http\Response
     */
    public function show(Rule_Set $rule_Set)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rule_Set  $rule_Set
     * @return \Illuminate\Http\Response
     */
    public function edit(Rule_Set $rule_Set)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rule_Set  $rule_Set
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rule_Set $rule_Set)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rule_Set  $rule_Set
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rule_Set $rule_set)
    {
        $rule_set->delete();
    }
}
