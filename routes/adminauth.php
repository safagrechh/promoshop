<?php

use App\Http\Controllers\AdminAuth\AuthenticatedSessionController;

use Illuminate\Support\Facades\Route;

Route::middleware('guest:admin')->group(function () {

    Route::get('admin/login', [AuthenticatedSessionController::class, 'create'])
                ->name('admin.login');

    Route::post('admin/login', [AuthenticatedSessionController::class, 'store']);

  
});

Route::middleware('auth:admin')->group(function () {

    Route::post('admin/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('admin.logout');
});
