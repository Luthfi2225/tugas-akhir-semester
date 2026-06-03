<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StockMonitoringController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    Route::resource('products', ProductController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    Route::resource('branches', BranchController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    Route::resource('users', UserController::class)->only([
        'index', 'store', 'update', 'destroy'
    ]);

    Route::get('/stock-monitoring', [StockMonitoringController::class, 'index'])->name('stock-monitoring.index');

    Route::get('/stock-in', [StockInController::class, 'index'])->name('stock-in.index');
    Route::post('/stock-in', [StockInController::class, 'store'])->name('stock-in.store');

    Route::get('/stock-out', [StockOutController::class, 'index'])->name('stock-out.index');
    Route::post('/stock-out', [StockOutController::class, 'store'])->name('stock-out.store');

    Volt::route('/pos', 'pos-component')->name('pos.index');
});

require __DIR__.'/auth.php';
