<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AccountController;

Route::get('/', function () {
    return view('mode');
});
Route::get('/mode', function () {
    return view('mode');
});
Route::get('/order', [ProductController::class, 'orderPage']);
Route::get('/view-order', [ProductController::class, 'viewOrderPage']);
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
    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/dashboard/menu', [AdminController::class, 'menu'])->name('admin.menu');
        Route::get('/dashboard/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
        Route::get('/dashboard/transactions/export', [AdminController::class, 'exportTransactions'])->name('admin.transactions.export');
        Route::get('/dashboard/transactions/export-pdf', [AdminController::class, 'exportTransactionsPdf'])->name('admin.transactions.export-pdf');
    });

    // Shared Routes (Admin & Cashier)
    Route::middleware(['role:admin,cashier'])->group(function () {
        Route::get('/dashboard/cashier', [AdminController::class, 'cashier'])->name('admin.cashier');
        Route::get('/dashboard/orders', [AdminController::class, 'orders'])->name('admin.orders');
    });

    // Admin Only Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard/accounts', [AccountController::class, 'index'])->name('admin.accounts');
        Route::post('/dashboard/accounts', [AccountController::class, 'store'])->name('admin.accounts.store');
        Route::put('/dashboard/accounts/{id}', [AccountController::class, 'update'])->name('admin.accounts.update');
        Route::delete('/dashboard/accounts/{id}', [AccountController::class, 'destroy'])->name('admin.accounts.destroy');
    });
});

// API Routes
Route::prefix('api')->group(function () {
    // Admin API Routes (Protected - Admin Only)
    Route::prefix('admin')->middleware(['admin.auth', 'role:admin,cashier'])->group(function () {
        Route::get('/orders/{orderNumber}', [AdminController::class, 'getOrderDetail']);
        Route::put('/orders/{orderNumber}/status', [AdminController::class, 'updateOrderStatus']);
        Route::get('/orders/{orderNumber}/kitchen-receipt', [AdminController::class, 'printKitchenReceipt'])->name('admin.orders.kitchen-receipt');
    });

    // Product API Routes (Protected - Admin Only)
    Route::middleware(['admin.auth', 'role:admin'])->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    });

    // Order API Routes (Public for customer orders)
    Route::post('/order', [OrderController::class, 'store']);
    Route::get('/order/{orderNumber}', [OrderController::class, 'show']);
    Route::get('/order/{orderNumber}/receipt', [OrderController::class, 'downloadReceipt'])->name('order.receipt');

    // Order Management Routes (Protected - Admin & Cashier)
    Route::middleware(['admin.auth', 'role:admin,cashier'])->group(function () {
        Route::put('/order/{orderNumber}', [OrderController::class, 'update']);
        Route::delete('/order/{orderNumber}', [OrderController::class, 'destroy']);
    });
});

// ====== QR CODE MEJA (ADMIN & CASHIER) ======
Route::middleware(['admin.auth', 'role:admin,cashier'])->group(function () {

    // List semua meja + tombol QR
    Route::get('/dashboard/tables', [OrderController::class, 'indexTables'])
        ->name('admin.tables.index');

    // Lihat QR Code per meja
    Route::get('/dashboard/tables/{id}/qr', [OrderController::class, 'showQR'])
        ->name('admin.tables.qr');

    // Lihat & Print QR Code per meja
    Route::get('/dashboard/tables/{id}/print', [OrderController::class, 'printQR'])
        ->name('admin.tables.print');

    // Tambah meja baru (admin only)
    Route::post('/dashboard/tables', [OrderController::class, 'storeTable'])
        ->name('admin.tables.store')
        ->middleware('role:admin');

});

// API Routes for Tables (admin only for delete)
Route::prefix('api')->middleware(['admin.auth', 'role:admin'])->group(function () {
    Route::delete('/tables/{id}', [OrderController::class, 'destroyTable'])->name('api.tables.destroy');
});
// Route Pelanggan (Hasil Scan QR)
Route::get('/order-menu', [OrderController::class, 'showMenu'])->name('pelanggan.menu');
