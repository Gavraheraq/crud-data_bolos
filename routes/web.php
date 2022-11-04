<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SesionController;

Route::get('/', function () {
    return view('welcome');
});

//route resource
Route::resource('/siswa', \App\Http\Controllers\BolosController::class);


Route::get('/sesi',[SesionController::class, 'index']);
Route::post('/sesi/login',[SesionController::class, 'login']);
Route::get('/sesi/logout',[SesionController::class, 'logout']);
Route::get('/sesi/register',[SesionController::class, 'register']);
Route::post('/sesi/create',[SesionController::class, 'create']);