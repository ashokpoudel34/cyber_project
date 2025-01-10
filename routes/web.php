<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SecurityToolController;


Route::get('/welcome', [HomeController::class, "welcome"])->name('site.welcome');

Route::get('/', [HomeController::class, "home_main"])->name('site.home');
Route::post('/', [SecurityToolController::class, "index"]);




