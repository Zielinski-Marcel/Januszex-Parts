<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::get('/user/{username}', [ProfileController::class, 'show']);


Route::redirect('/', '/dashboard');

Route::get('/dashboard/{vehicle?}', [\App\Http\Controllers\DashboardController::class, "show"])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('IsUserAdmin')->group(function () {
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin');
    Route::get('/admin/logs', [AdminDashboardController::class, 'logs'])->name('logs');

    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::patch('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    Route::get('/admin/logs/{user}', [UserController::class, 'userLogs'])->name('admin.users.logs');

});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/create/product', [ProductController::class, 'create']);
    Route::get('/edit/product/{product}', [ProductController::class, 'edit']);
    Route::post('/create/product', [ProductController::class, 'store'])->name('createProduct');
    Route::patch('/edit/product/{product}', [ProductController::class, 'update'])->name('editProduct');
    Route::delete('/delete/product/{product}', [ProductController::class, 'destroy'])->name('deleteProduct');
});

require __DIR__.'/auth.php';
