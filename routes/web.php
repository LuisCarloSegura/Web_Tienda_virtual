<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/categoria/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::get('/register', [RegistroController::class, 'mostrarFormulario'])->name('register');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.store');
Route::post('/register', [RegistroController::class, 'registrar'])->name('register.store');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/logout/cambiar-cuenta', [AuthenticatedSessionController::class, 'switchAccount'])->name('logout.switch');