<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function show(Categoria $categoria)
    {
        $categoria->load('subcategorias');
        if ($categoria->subcategorias->isNotEmpty()) {
            $idsCategorias = $categoria->subcategorias
                ->pluck('id_categoria')
                ->push($categoria->id_categoria);
        } else {
            $idsCategorias = collect([$categoria->id_categoria]);
        }

        $productos = Producto::with('imagenPrincipal')
            ->whereIn('id_categoria', $idsCategorias)
            ->paginate(12);

        return view('client.categorias.show', compact('categoria', 'productos'));
    }
}