<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/webhook', [BotController::class, 'webhook']);
