<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $productos = Producto::with('imagenPrincipal')
            ->latest()
            ->take(8)
            ->get();

        return view('client.dashboard.index', compact('productos'));
    }
}