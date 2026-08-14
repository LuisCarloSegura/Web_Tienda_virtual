<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// ==================== RUTAS PÚBLICAS ====================
Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('/categoria/{categoria}', [CategoriaController::class, 'show'])
    ->name('categorias.show');

// ==================== RUTAS SOLO PARA INVITADOS (GUEST) ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
    Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.store');
});

// ==================== RUTAS DE CIERRE DE SESIÓN ====================
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/logout/cambiar-cuenta', [AuthenticatedSessionController::class, 'switchAccount'])->name('logout.switch');