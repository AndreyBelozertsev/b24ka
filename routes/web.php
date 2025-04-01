<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BitrixController;

Route::get('/', function () {

    return view('welcome');
});

Route::post('/b24/install', [BitrixController::class, 'install']);

Route::post('/b24/index', [BitrixController::class, 'index']);
