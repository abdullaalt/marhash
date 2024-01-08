<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\V1\ContentController;
use App\Http\Controllers\V1\UserController;
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


Route::prefix('sanctum')->namespace('API')->group(function() {
    //Route::middleware('auth:sanctum')->post('register', 'AuthController@register');
    Route::post('token', [AuthenticatedSessionController::class, 'token']);
});
