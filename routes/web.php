<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoriaController;

Route::get('/', function () {
    return view('client.dashboard.index');
})->name('dashboard');

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('/categoria/{categoria}', [CategoriaController::class, 'show'])
    ->name('categorias.show');