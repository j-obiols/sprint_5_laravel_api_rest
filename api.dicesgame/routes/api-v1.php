<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [UserController::class, 'store'])->name('users.create');
Route::post('/login', [UserController::class, 'login'])->name('users.login');
Route::middleware('auth:api')->put('/users/{id}', [UserController::class, 'update'])->name('users.update');

Route::middleware('auth:api')->post('/players', [PlayerController::class, 'store'])->name('players.create');
//This route passes to Users
//Route::middleware('auth:api')->put('/players/{id}', [UserController::class, 'update'])->name('users.update');
Route::middleware('auth:api')->post('/players/{id}/games', [GameController::class, 'store'])->name('games.create');
