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
    Route::get('board/{id}', 'BoardController@show');
    Route::get('create-board', 'BoardController@store');
    Route::post('update-board/{id}', 'BoardController@update');
    Route::get('delete-board/{id}', 'BoardController@destroy');

    //MODULE
    Route::get('modules', 'ModuleController@index');
    Route::get('module/{id}', 'ModuleController@show');
    Route::get('create-module', 'ModuleController@create');
    Route::post('create-module', 'ModuleController@store');
    Route::post('update-module/{id}', 'ModuleController@update');
    Route::get('delete-module/{id}', 'ModuleController@destroy');


});