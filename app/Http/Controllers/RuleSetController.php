<?php

namespace App\Http\Controllers;

use App\Model\Module;
use App\Model\Rule_Set;
use App\Model\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RuleSetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rule_sets = Rule_Set::All();


        return view('admin.rule-sets.rule-sets', ['rule_sets' => $rule_sets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::All();

        $solutions = Solution::All();
        return view('admin.rule-sets.new-rule-set',['modules' => $modules, 'solutions' => $solutions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule_set = New Rule_Set();
        $combination = '';
        if(!empty($request->led_1)) {
            $combination .= $request->led_1;
        } else {
            $combination .= '0';
        }
        if(!empty($request->led_2)) {
            $combination .= $request->led_2;
        } else {
            $combination .= '0';
        }
        if(!empty($request->led_3)) {
            $combination .= $request->led_3;
        } else {
            $combination .= '0';
        }
        if(!empty($request->led_4)) {
            $combination .= $request->led_4;
        } else {
            $combination .= '0';
        }
        $rule_set->combination = bindec($combination);

        $rule_set->save();

        $count = 0;
        foreach($request->id_module as $id_module) {
            $rule_set->modules()->attach($id_module, ['id_solution' => $request->id_solution[$count]]);
            $count++;
        }


        return Redirect::to('/admin/rule-sets');
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
    public function destroy(Rule_Set $rule_Set)
    {
        $rule_Set->delete();
        return Redirect::to('/admin/rule-sets');
    }
}
