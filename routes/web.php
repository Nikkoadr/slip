<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/webhook', [BotController::class, 'webhook']);

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
