<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoAdminController extends Controller
{
    // Listado con crear/editar/eliminar
    public function index()
    {
        $productos = Producto::with('categoria', 'imagenPrincipal')->latest()->paginate(10);
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('admin.productos.form', compact('categorias'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'imagen'       => 'nullable|image|max:2048', // máx 2MB
        ]);

        $producto = Producto::create([
            'nombre'       => $datos['nombre'],
            'descripcion'  => $datos['descripcion'] ?? null,
            'precio'       => $datos['precio'],
            'stock'        => $datos['stock'],
            'id_categoria' => $datos['id_categoria'],
        ]);

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');

            ImagenProducto::create([
                'id_producto' => $producto->id_producto,
                'url_imagen'  => 'storage/' . $ruta,
                'orden'       => 0,
            ]);
        }

        return redirect()
            ->route('admin.productos.index')
            ->with('exito', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $producto->load('imagenPrincipal');
        return view('admin.productos.form', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $datos = $request->validate([
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'nullable|string',
            'precio'       => 'required|numeric|min:0',
            'stock'        => 'required|integer|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'imagen'       => 'nullable|image|max:2048',
        ]);

        $producto->update([
            'nombre'       => $datos['nombre'],
            'descripcion'  => $datos['descripcion'] ?? null,
            'precio'       => $datos['precio'],
            'stock'        => $datos['stock'],
            'id_categoria' => $datos['id_categoria'],
        ]);

        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');

            // Reemplaza la imagen principal (borra la anterior del disco)
            $anterior = $producto->imagenPrincipal;
            if ($anterior) {
                Storage::disk('public')->delete(str_replace('storage/', '', $anterior->url_imagen));
                $anterior->update(['url_imagen' => 'storage/' . $ruta]);
            } else {
                ImagenProducto::create([
                    'id_producto' => $producto->id_producto,
                    'url_imagen'  => 'storage/' . $ruta,
                    'orden'       => 0,
                ]);
            }
        }

        return redirect()
            ->route('admin.productos.index')
            ->with('exito', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        // Borra las imágenes del disco antes de borrar el producto
        foreach ($producto->imagenes as $imagen) {
            Storage::disk('public')->delete(str_replace('storage/', '', $imagen->url_imagen));
        }

        $producto->delete();

        return redirect()
            ->route('admin.productos.index')
            ->with('exito', 'Producto eliminado correctamente.');
    }
}