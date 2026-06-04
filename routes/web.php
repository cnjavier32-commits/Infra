<?php

use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

// ================================================================
//  RUTAS PÚBLICAS — Solo para usuarios NO autenticados
// ================================================================
Route::middleware('guest')->group(function () {

    // Pantalla de login
    Route::get('/', [LoginController::class, 'index'])
        ->name('login.index');

    // Procesar login
    Route::post('/login', [LoginController::class, 'login'])
        ->name('login')
        ->middleware('throttle:5,1');

    // Recuperación de contraseña
    Route::prefix('auth')->name('password.')->group(function () {

        Route::post('/forgot-password', [PasswordResetController::class, 'sendCode'])
            ->name('send-code');            // → password.send-code

        Route::post('/verify-code', [PasswordResetController::class, 'verifyCode'])
            ->name('password.verify-code');         // → password.verify-code

        Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])
            ->name('reset');               // → password.reset

        Route::post('/auth/reset-password', [PasswordResetController::class, 'resetPassword']);

    });

});

// ================================================================
//  RUTAS PROTEGIDAS — Solo para usuarios autenticados
// ================================================================
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard.index');          // → /dashboard

    // Cerrar sesión
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::get('/ingresos', [IncomeController::class, 'index'])
        ->name ('income.index');

    Route::get('/material', [MaterialController::class, 'index'])
        ->name ('material.index');

});
