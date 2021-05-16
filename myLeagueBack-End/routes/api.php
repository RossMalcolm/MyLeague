<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Import Controller
use App\Http\Controllers\LeagueController;
use Illuminate\Validation\Rules\Dimensions;

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


Route::get('/leagues', [LeagueController::class, 'index'])->name('show.leagues');
Route::get('/leagues/{league_id}', [LeagueController::class, 'show'])->name('show.league');

Route::get('/schedule', [LeagueController::class, 'schedule']);
Route::get('/leaderboard', [LeagueController::class, 'leaderboard']);
Route::get('/stats', [LeagueController::class, 'stats']);

Route::post('/login', [LeagueController::class, 'login']);
Route::post('/leagues', [LeagueController::class, 'create']);
Route::post('/createGame', [LeagueController::class, 'createGame']);
Route::post('/updateGame', [LeagueController::class, 'updateGame']);