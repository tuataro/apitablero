<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartidaController;

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

Route::post('/partida', [PartidaController::class, 'store']);
Route::post('/partida/moviments', [PartidaController::class, 'moviment']);
Route::get('/partida/registre/{id}', [PartidaController::class,'registre']);
