<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;


Route::get('/', function () {
    return view('welcome');
});


Route::post('/cars', [CarController::class, 'store'])->name("create_car");
Route::put('/cars', [CarController::class, 'update'])->name("update_car");