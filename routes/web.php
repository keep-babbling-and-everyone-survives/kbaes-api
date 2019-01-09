<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->prefix('admin')->group(function() {

    //BOARD
    Route::get('boards', 'BoardController@index');
    Route::get('create-board', 'BoardController@store');
    Route::get('delete-board/{id}', 'BoardController@destroy');

    //MODULE
    Route::get('modules', 'ModuleController@index');
    Route::get('create-module', 'ModuleController@create');
    Route::post('create-module', 'ModuleController@store');
    Route::get('delete-module/{id}', 'ModuleController@destroy');

    //SOLUTION
    Route::get('solutions', 'SolutionController@index');
    Route::get('create-solution', 'SolutionController@create');
    Route::post('create-solution', 'SolutionController@store');
    Route::get('delete-solution/{id}', 'SolutionController@destroy');

    //RULE SETS
    Route::get('rule-sets', 'RuleSetController@index');
    Route::get('create-rule-set', 'RuleSetController@create');
    Route::post('create-rule-set', 'RuleSetController@store');
    Route::get('delete-rule-set/{id}', 'RuleSetController@destroy');

    //OPTIONS
    Route::get('options', 'OptionsController@index');
    Route::get('create-option', 'OptionsController@create');
    Route::post('create-option', 'OptionsController@store');
    Route::get('delete-option/{id}', 'OptionsController@destroy');

    //GAMES
    Route::get('games', 'GameController@index');
    Route::get('delete-option/{id}', 'OptionsController@destroy');
});