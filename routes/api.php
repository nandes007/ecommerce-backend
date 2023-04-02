<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResendVerificationController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RajaOngkirController;
use Illuminate\Support\Facades\Route;

/**
 * Admin endpoint
 */
Route::prefix('/admin')->group(function () {
    /**
     * Category Endpoint
     */
    Route::get('/categories/search', [\App\Http\Controllers\Admin\CategoryController::class, 'search']);
    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['create', 'edit']);

    /**
     * Product Endpoint
     */
    Route::resource('/products', \App\Http\Controllers\Admin\ProductController::class)->except(['create', 'edit']);

    /**
     * Province Endpoint
     */
    Route::get('/provinces/all', [\App\Http\Controllers\Admin\ProvinceController::class, 'getAllProvinceWithoutPagination']);
    Route::resource('/provinces', \App\Http\Controllers\Admin\ProvinceController::class)->except(['create', 'edit']);

    /**
     * City Endpoint
     */
    Route::resource('/cities', \App\Http\Controllers\Admin\CityController::class)->except(['create', 'edit']);

    /**
     * Banner Endpoint
     */
    Route::resource('/banners', \App\Http\Controllers\Admin\BannerController::class)->except(['create', 'edit'])->middleware('auth:sanctum');
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
Route::prefix('/rajaongkir')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/cost/{courier}', [RajaOngkirController::class, 'checkOngkir']);
    });
    // Route::get('/provinces', [RajaOngkirController::class, 'getProvince']);
    // Route::get('/cities/{provinceId}', [RajaOngkirController::class, 'getCities']);
});

//Route::middleware('auth:sanctum')->group(function () {
//    Route::get('/orders', [OrderController::class, 'index']);
//    Route::post('/orders', [OrderController::class, 'store']);
//});

