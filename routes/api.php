<?php

use Illuminate\Http\Request;
use App\Http\Controllers\RaspberryInterface;

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

Route::get('/game/send/{id}', function($id) {
    event(new App\Events\GameStarted($id));
});

Route::post('/game/start/', 'WebInterface@startGame')->middleware('auth:api');
Route::get('/game/{id}/abort', 'WebInterface@abortGame');
Route::get('/game/{id}', "WebInterface@getGameStatus");

Route::post('/game/{id}/confirm', 'RaspberryInterface@confirmGame');
Route::post('/game/{gameid}/answer/{rsid}', 'RaspberryInterface@answerRuleset');
Route::get('/game/{id}/current', 'RaspberryInterface@requestCurrentRuleset');

Route::get('/game/trigger/{id}', function ($id) {
    $game = new App\Model\Game();
    $game->id=$id;
    event(new App\Events\Website\GameCreatedSuccess($game));
});

Route::get('/gameBoardModule/{id}', 'WebInterface@getRuleSets');