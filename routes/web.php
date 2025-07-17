<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Sales Routes
    Route::prefix('sales')->name('sales.')->group(function () {
        Route::get('/pos', function () {
            return Inertia::render('Sales/POS');
        })->name('pos');

        Route::get('/orders', function () {
            return Inertia::render('Sales/Orders');
        })->name('orders');

        Route::get('/invoices', function () {
            return Inertia::render('Sales/Invoices');
        })->name('invoices');
    });

    // Inventory Routes
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Products/Index');
        })->name('index');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Categories/Index');
        })->name('index');
    });

    Route::prefix('suppliers')->name('suppliers.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Suppliers/Index');
        })->name('index');
    });

    Route::prefix('stock')->name('stock.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Stock/Index');
        })->name('index');
    });

    // Customer Routes
    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Customers/Index');
        })->name('index');

        Route::get('/groups', function () {
            return Inertia::render('Customers/Groups');
        })->name('groups');
    });

    // Reports Routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/sales', function () {
            return Inertia::render('Reports/Sales');
        })->name('sales');

        Route::get('/inventory', function () {
            return Inertia::render('Reports/Inventory');
        })->name('inventory');

        Route::get('/financial', function () {
            return Inertia::render('Reports/Financial');
        })->name('financial');
    });

    // Transactions Routes
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', function () {
            return Inertia::render('Transactions/Index');
        })->name('index');
    });

    // Settings Routes
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/general', function () {
            return Inertia::render('Settings/General');
        })->name('general');

        Route::get('/users', function () {
            return Inertia::render('Settings/Users');
        })->name('users');

        Route::get('/system', function () {
            return Inertia::render('Settings/System');
        })->name('system');
    });
});

// In your routes/web.php
Route::get('/sales', function () {
    return Inertia::render('Sales/Index');
})->name('sales');

require __DIR__.'/auth.php';
