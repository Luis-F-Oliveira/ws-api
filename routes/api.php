<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\CommitController;
use App\Http\Controllers\SectorController;

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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::apiResource('sectors', SectorController::class)->only(['index']);
Route::apiResource('commands', CommandController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('users', UserController::class)->except(['store']);
    Route::apiResource('commits', CommitController::class);
    Route::get('commits/answered/{id}', [CommitController::class, 'updateAnswered']);
    Route::apiResource('sectors', SectorController::class)->except(['index']);
    Route::get('charts/sectors', [ChartController::class, 'sectors']);
});