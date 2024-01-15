<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\V1\PointsController;
use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\TeamsController;
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

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUser']);

Route::get('/hello', function (Request $request) {
    return 'hello';
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/taskmanager/boards', [ContentController::class, 'getBoardsList']);

});

Route::prefix('points')->middleware('auth:sanctum')->group(function(){
    Route::get('/', [PointsController::class, 'points']);
    Route::post('/', [PointsController::class, 'addPoint']);
    Route::post('/update', [PointsController::class, 'updatePoint']);
    Route::delete('/{point_id}', [PointsController::class, 'deletePoint']);
});

Route::prefix('teams')->middleware('auth:sanctum')->group(function(){
    Route::get('/', [TeamsController::class, 'teams']);

    Route::post('/', [TeamsController::class, 'addTeam']);
    Route::post('/update', [TeamsController::class, 'updateTeam']);
    Route::delete('/{team_id}', [TeamsController::class, 'deleteTeam']);

    Route::get('/{team_id}/persons', [TeamsController::class, 'teamPersons']);
    Route::delete('/{team_id}/persons/{person_id}', [TeamsController::class, 'deletePersonFromTeam']);

    Route::get('/{team_id}/points', [TeamsController::class, 'teamPoints']);
    Route::delete('/{team_id}/points', [TeamsController::class, 'deletePoints']);
    Route::post('/{team_id}/points', [TeamsController::class, 'addPoints']);

    Route::get('/{team_id}/invitations', [TeamsController::class, 'teamInvitations']);
    Route::post('/{team_id}/invitations', [TeamsController::class, 'addInvitation']);
    Route::get('/{team_id}/invitations/accept', [TeamsController::class, 'acceptInvitation']);
    Route::get('/{team_id}/invitations/reject', [TeamsController::class, 'rejectInvitation']);
});

Route::prefix('sanctum')->namespace('API')->group(function() {
    //Route::middleware('auth:sanctum')->post('register', 'AuthController@register');
    Route::post('token', [AuthenticatedSessionController::class, 'token']);
});

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware('guest');
