<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoicesController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::group(['prefix' => 'invoices', 'as' => 'invoices.'], function () {
        Route::get('/{password}', [InvoicesController::class, 'index'])->name('index');
        Route::get('/{password}/{invoice}', [InvoicesController::class, 'show'])->name('show');
        Route::post('/{password}', [InvoicesController::class, 'store'])->name('store');
    });
});
