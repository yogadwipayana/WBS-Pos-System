<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('mode');
});
Route::get('/mode', function () {
    return view('mode');
});
Route::get('/order', function () {
    return view('order');
});
Route::get('/view-order', function () {
    return view('view-order');
});
Route::get('/payment', function () {
    return view('payment');
});
Route::get('/cashier-confirmation', function () {
    return view('cashier-confirmation');
});
Route::get('/profile', function () {
    return view('profile');
});
Route::get('/qris-confirmation', function () {
    return view('qris-confirmation');
});
Route::get('/order-success', function () {
    return view('order-success');
});

// Admin Authentication Routes
Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/cashier', [AdminController::class, 'cashier'])->name('admin.cashier');
    Route::get('/dashboard/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/dashboard/menu', [AdminController::class, 'menu'])->name('admin.menu');
    Route::get('/dashboard/settings', [AdminController::class, 'settings'])->name('admin.settings');
});

// API Routes
Route::prefix('api')->group(function () {
    // Admin API Routes (Protected)
    Route::prefix('admin')->middleware(['admin.auth'])->group(function () {
        Route::post('/settings', [AdminController::class, 'updateSettings']);
        Route::get('/orders/{orderNumber}', [AdminController::class, 'getOrderDetail']);
        Route::put('/orders/{orderNumber}/status', [AdminController::class, 'updateOrderStatus']);
    });

    // Order API Routes (Public for customer orders)
    Route::post('/order', [OrderController::class, 'store']);
    Route::get('/order/{orderNumber}', [OrderController::class, 'show']);
    
    // Order Management Routes (Protected for admin)
    Route::middleware(['admin.auth'])->group(function () {
        Route::put('/order/{orderNumber}', [OrderController::class, 'update']);
        Route::delete('/order/{orderNumber}', [OrderController::class, 'destroy']);
    });
});
