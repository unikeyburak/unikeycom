<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\DealerController;
use App\Http\Controllers\Api\V1\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// API Version 1
Route::prefix('v1')->middleware(['throttle:api'])->group(function () {
    
    // Public endpoints
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::get('/categories/{category}/products', [CategoryController::class, 'products']);
    
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/products/search', [ProductController::class, 'search']);
    
    // Dealer authentication (daha sıkı rate limit)
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware('throttle:login');
    Route::post('/auth/register', [AuthController::class, 'register']);
    
    // Protected dealer endpoints (authenticated users get higher rate limit)
    Route::middleware(['auth:api', 'throttle:api:auth'])->group(function () {
        // Auth
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'me']);
        Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
        Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
        
        // Dealer info
        Route::get('/dealer/profile', [DealerController::class, 'profile']);
        Route::put('/dealer/profile', [DealerController::class, 'updateProfile']);
        
        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/orders', [OrderController::class, 'store']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::put('/orders/{order}', [OrderController::class, 'update']);
        Route::delete('/orders/{order}', [OrderController::class, 'cancel']);
        
        // API Token management
        Route::get('/tokens', [AuthController::class, 'tokens']);
        Route::post('/tokens', [AuthController::class, 'createToken']);
        Route::delete('/tokens/{token}', [AuthController::class, 'revokeToken']);
    });
});