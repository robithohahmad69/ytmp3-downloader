<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\YoutubeController;

Route::get('/', [YoutubeController::class, 'index']);
Route::post('/download',     [YoutubeController::class, 'download']);
Route::get('/search',        [YoutubeController::class, 'search']);