<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductoAdminController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\ProductoController;

use App\Http\Controllers\PerfilController;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
Route::get('/categoria/{categoria}', [CategoriaController::class, 'show'])->name('categorias.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/mi-cuenta', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/mi-cuenta', [PerfilController::class, 'update'])->name('perfil.update');
});

Route::get('/registro', [RegistroController::class, 'mostrarFormulario'])->name('registro');
Route::get('/register', [RegistroController::class, 'mostrarFormulario'])->name('register');
Route::post('/registro', [RegistroController::class, 'registrar'])->name('registro.store');
Route::post('/register', [RegistroController::class, 'registrar'])->name('register.store');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::post('/logout/cambiar-cuenta', [AuthenticatedSessionController::class, 'switchAccount'])->name('logout.switch');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin']) // 'admin' = el middleware EsAdministrador
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('productos', ProductoAdminController::class)->except(['show']);
    });

Route::get('/sobre-nosotros', [PaginaController::class, 'nosotros'])->name('nosotros');
Route::get('/metodos-de-pago', [PaginaController::class, 'pagos'])->name('pagos');
Route::get('/contactanos', [PaginaController::class, 'contacto'])->name('contacto');

Route::get('/producto/{producto}', [ProductoController::class, 'show'])
    ->name('productos.show');