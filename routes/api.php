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
use App\Http\Controllers\RajaOngkirController;
use Illuminate\Support\Facades\Route;

/**
 * Admin endpoint
 */
Route::prefix('/admin')->group(function () {
    Route::get('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get('/categories/search', [\App\Http\Controllers\Admin\CategoryController::class, 'search']);
    Route::post('/categories', [\App\Http\Controllers\Admin\CategoryController::class, 'store']);
    Route::get('/categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'show']);
    Route::patch('categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'update']);
    Route::delete('categories/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'delete']);

    Route::get('/products', [\App\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::get('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'show']);
    Route::post('/products', [\App\Http\Controllers\Admin\ProductController::class, 'store']);
    Route::patch('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::delete('/products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'destroy']);
});

/**
 * User Endpoint
 */
Route::get('/users', [UserController::class, 'profile'])->middleware('auth:sanctum', 'is_verified');
Route::prefix('/users')->group(function () {
    Route::middleware(['auth:sanctum', 'is_verified'])->group(function () {
        Route::get('/logout', [UserController::class, 'logout']);
        Route::get('/change-password', ChangePasswordController::class);
        Route::put('/update', [UserController::class, 'updateProfile']);
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

/**
 * Cart Endpoint
 */
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/carts', [CartController::class, 'index']);
    Route::get('/carts/{id}', [CartController::class, 'show']);
    Route::post('/carts', [CartController::class, 'store']);
    Route::post('/carts/delete', [CartController::class, 'destroy']);
    Route::patch('/carts/update', [CartController::class, 'update']);
});

/**
 * Raja Ongkir Endpoint
 * This is third party api provide by raja ongkir
 */
Route::get('/rajaongkir/provinces', [RajaOngkirController::class, 'getProvince']);
Route::get('/rajaongkir/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);
