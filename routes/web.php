<?php

use App\Http\Controllers\KeluhanPelangganController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::post('/keluhanPost', [KeluhanPelangganController::class, 'postCreate']);
Route::get('/keluhan', [KeluhanPelangganController::class, 'index']);
Route::get('/keluhanDetail/{id}', [KeluhanPelangganController::class, 'detail']);
Route::put('/keluhanUpdate/{id}', [KeluhanPelangganController::class, 'update']);
Route::get('/keluhan/export/{format}', [KeluhanPelangganController::class, 'export']);

Auth::routes();

Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])
    ->where('any', '.*')
    ->name('home');
