<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class ProductoController extends Controller
{
    public function show(Producto $producto)
    {
        $producto->load('imagenes', 'categoria');

        return view('client.productos.show', compact('producto'));
    }
}