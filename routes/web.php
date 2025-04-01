<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BitrixController;

Route::get('/', function () {

    return view('welcome');
});

Route::get('/b24/install', [BitrixController::class, 'install']);

Route::get('/b24/index', [BitrixController::class, 'index']);
