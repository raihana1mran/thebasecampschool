<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\MockTestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReferralController;
use App\Http\Middleware\EnsureIsAdmin;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});

// Admin Routes (Protected)
Route::middleware(['auth:sanctum', EnsureIsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/stats', [AdminController::class, 'stats']);
    Route::get('/students', [AdminController::class, 'students']);
    Route::post('/message', [AdminController::class, 'message']);
});

// Admission Routes
Route::middleware('auth:sanctum')->prefix('admissions')->group(function () {
    Route::post('/', [AdmissionController::class, 'submitAdmission']);
    Route::get('/me', [AdmissionController::class, 'getMyAdmissions']);
    
    // Admin checks
    Route::get('/', [AdmissionController::class, 'getAdmissions'])->middleware(EnsureIsAdmin::class);
    Route::put('/{id}/status', [AdmissionController::class, 'updateAdmissionStatus'])->middleware(EnsureIsAdmin::class);
});

// Mock Test Routes
Route::middleware('auth:sanctum')->prefix('mocktests')->group(function () {
    Route::get('/', [MockTestController::class, 'getMockTests']);
    Route::get('/{id}', [MockTestController::class, 'getMockTest']);
    Route::post('/{id}/submit', [MockTestController::class, 'submitMockTest']);
    
    // Admin checks
    Route::post('/', [MockTestController::class, 'createMockTest'])->middleware(EnsureIsAdmin::class);
    Route::delete('/{id}', [MockTestController::class, 'deleteMockTest'])->middleware(EnsureIsAdmin::class);
});

// Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'getProducts']);
    Route::get('/{id}', [ProductController::class, 'getProduct']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/{id}/unlock', [ProductController::class, 'unlockProduct']);
        
        // Admin checks
        Route::post('/', [ProductController::class, 'createProduct'])->middleware(EnsureIsAdmin::class);
        Route::delete('/{id}', [ProductController::class, 'deleteProduct'])->middleware(EnsureIsAdmin::class);
    });
});

// Referral Routes
Route::prefix('referrals')->group(function () {
    Route::post('/verify', [ReferralController::class, 'verifyReferralCode']);
    Route::get('/me', [ReferralController::class, 'getMyReferrals'])->middleware('auth:sanctum');
});

// Payment Routes
Route::middleware('auth:sanctum')->prefix('payments')->group(function () {
    Route::post('/order', [PaymentController::class, 'createOrder']);
    Route::post('/verify', [PaymentController::class, 'verifyPayment']);
    Route::get('/me', [PaymentController::class, 'getMyPayments']);
});
