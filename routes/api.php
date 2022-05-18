<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\GameController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\StatisticController;
use App\Http\Controllers\API\UserController;
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

Route::post('/register', [AuthController::class , 'register']);
Route::post('/login', [AuthController::class , 'login']);

Route::resource('user', UserController::class );
Route::resource('post', PostController::class );
Route::resource('statistic', StatisticController::class );
Route::resource('comment', CommentController::class );
Route::resource('game', GameController::class );

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::get('/profile', function(Request $request){
        return auth()->user();
    });

    Route::post('/logout', [AuthController::class , 'logout']);
});

