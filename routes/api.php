<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/web-interface/{game}', 'WebInterface@startGame');
Route::get('/raspberry-interface', 'RaspberryInterface@index')->middleware('client:raspberry-scope');


Route::post('/game/start/', 'WebInterface@startGame');
Route::post('/get-raspberry-game-created/{id}', 'GameController@gameCreationSuccess');