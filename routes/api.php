<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KemacetanController;
use App\Http\Controllers\Api\KecelakaanController;
use App\Http\Controllers\Api\PosGaturController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('kemacetan', [KemacetanController::class, 'index']);
Route::get('kemacetan/detail/{id}', [KemacetanController::class, 'show']);

Route::get('kecelakaan', [KecelakaanController::class, 'index']);
Route::get('kecelakaan/detail/{id}', [KecelakaanController::class, 'show']);

Route::get('pos-gatur', [PosGaturController::class, 'index']);