<?php

use App\Http\Controllers\V1\AnimalController;
use App\Http\Controllers\V1\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], static function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth:api'], static function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('animals', [AnimalController::class, 'index'])->name('animals.index');
