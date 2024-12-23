<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CashierReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PosUserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('items', ItemController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('users', UserController::class);
    Route::resource('pos-users', PosUserController::class);
    Route::resource('cashier-reports', CashierReportController::class);
    Route::get('/exportpdf', [CashierReportController::class, 'exportPdf']);
    // Route::get('/exportpdf', function () {
    //     return "redirect()->route('login')";
    // });


    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
