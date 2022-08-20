<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'profile'])->middleware('auth:sanctum', 'is_verified');
Route::prefix('/users')->group(function () {
    Route::middleware(['auth:sanctum', 'is_verified'])->group(function () {
        Route::get('/logout', [UserController::class, 'logout']);
        Route::get('/change-password', ChangePasswordController::class);
    });
    Route::middleware('is_verified')->group(function () {
        Route::post('/login', LoginController::class);
        Route::post('/forgot-password', [ResetPasswordController::class, 'send']);
        Route::post('/reset-password', [ResetPasswordController::class, 'reset']);
    });

    Route::post('/register', [RegisterController::class, 'send'])->middleware('is_not_verified');
    Route::post('/verify', [RegisterController::class, 'verify']);
    Route::post('/resend-verification', ResendVerificationController::class);
    Route::post('/check', [UserController::class, 'check']);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/carts', [CartController::class, 'index']);
    Route::get('/carts/{id}', [CartController::class, 'show']);
    Route::post('/carts', [CartController::class, 'store']);
    Route::post('/carts/delete', [CartController::class, 'destroy']);
    Route::get('/carts/user/cart', [CartController::class, 'find']);
    Route::patch('/carts/update', [CartController::class, 'update']);
});
