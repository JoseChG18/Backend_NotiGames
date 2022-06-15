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

Route::post('/register', [AuthController::class , 'register'])->name("auth.register");
Route::post('/login', [AuthController::class , 'login'])->name("auth.login");

Route::post('post/search', [PostController::class , 'searchByName'])->name("post.search");
Route::get('post/{post}', [PostController::class , 'show'])->name("post.show");
Route::get('post', [PostController::class , 'index'])->name("post.index");

Route::get('game', [GameController::class , 'index'])->name("game.index");

Route::get('user/{user}', [UserController::class , 'show'])->name("user.show");
Route::get('user/avatar/{user}',[UserController::class , 'getProfile'])->name('user.getProfile');
Route::group(['middleware' => ['auth:sanctum']], function (){

    Route::prefix('user')->group(function () {
        Route::delete('{user}', [UserController::class , 'destroy'])->name("user.destroy");
        Route::get('/', [UserController::class , 'index'])->name("user.index");
        Route::put('{user}', [UserController::class , 'update'])->name("user.update");
        Route::post('avatar/{user}',[UserController::class , 'updateProfile'])->name('user.updateProfile');
    });
    Route::put('admin/{user}', [UserController::class , 'addAdmin'])->name("user.admin");

    Route::prefix('post')->group(function () {
        Route::put('{post}', [PostController::class , 'update'])->name("post.update");
        Route::delete('{post}', [PostController::class , 'destroy'])->name("post.destroy");
        Route::post('/', [PostController::class , 'store'])->name("post.store");
    });

    Route::resource('statistic', StatisticController::class );
    Route::resource('comment', CommentController::class );


    Route::prefix('game')->group(function () {
        Route::post('/', [GameController::class , 'store'])->name("game.store");
        Route::delete('{game}', [GameController::class , 'destroy'])->name("game.destroy");
        Route::get('{game}', [GameController::class , 'show'])->name("game.show");
        Route::put('{game}', [GameController::class , 'update'])->name("game.update");
    });
    
    Route::post('/logout', [AuthController::class , 'logout'])->name("auth.logout");
});

