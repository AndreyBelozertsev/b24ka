<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BitrixController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\AuthBitrixController;


Route::get('/', [HomeController::class, 'index']);

Route::post('/b24/install', [BitrixController::class, 'install']);

Route::post('/b24/index', [BitrixController::class, 'index']);

Route::post('/b24/oauth/callback', [AuthBitrixController::class, 'callback']);

Route::post('/b24/test', [PositionController::class, 'test']);

