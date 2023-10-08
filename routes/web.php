<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/user', static fn() => response()->json());

Route::get('/upload', [UploadController::class, 'index']);
Route::post('/upload', [UploadController::class, 'store']);

Route::get('static/media', [MediaController::class, 'show'])->where('path', '.*')->name('media.show');
