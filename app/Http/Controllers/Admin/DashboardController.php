<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Producto::count();
        $totalCategorias = Categoria::count();
        $sinStock = Producto::where('stock', 0)->count();
        $ultimosProductos = Producto::with('categoria')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProductos', 'totalCategorias', 'sinStock', 'ultimosProductos'
        ));
    }
}