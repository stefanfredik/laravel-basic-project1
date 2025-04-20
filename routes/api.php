<?php

use App\Http\Controllers\API\AuthController as APIAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CategoryController;
use App\Models\Product;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request;
});

// Auth Routes
Route::post('/login', [APIAuthController::class], 'login');
Route::post('/register', [APIAuthController::class, 'register']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, "index"]);
Route::get('/categories/{category}', [CategoryController::class, 'show']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{products}', [ProductController::class, "update"]);
    Route::delete('/products/{products}', [ProductController::class, "destroy"]);

    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{category}', [CategoryController::class, "update"]);
    Route::delete('/categories/{category}', [CategoryController::class, "destroy"]);
});
