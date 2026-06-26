<?php

use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/products', [WarehouseController::class, 'index']);
Route::get('/products/{id}', [WarehouseController::class, 'show']);
Route::post('/products', [WarehouseController::class, 'store']);
Route::patch('/products/{id}', [WarehouseController::class, 'update']);
Route::delete('/products/{id}', [WarehouseController::class, 'destroy']);
