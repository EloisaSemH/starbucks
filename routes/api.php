<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CategoryController, ProductController, ExtraController, OrderController};

Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('extras', ExtraController::class);

Route::post('orders', [OrderController::class, 'store']);
