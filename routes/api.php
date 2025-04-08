<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CategoryController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request;
});

// Auth Routes
Route::post('/login', [AuthController::class], 'login');
Route::post('/register', [AUthController::class, 'register']);
