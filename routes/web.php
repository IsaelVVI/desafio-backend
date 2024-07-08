<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PhotoController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/cars', [CarController::class, 'index'])->name("index_car");
Route::post('/cars', [CarController::class, 'store'])->name("create_car");
Route::put('/cars/{id}', [CarController::class, 'update'])->name("update_car");
Route::delete('/cars/{id}', [CarController::class, 'destroy'])->name("delete_car");

Route::post('/photos', [PhotoController::class, 'store'])->name('upload_photos');