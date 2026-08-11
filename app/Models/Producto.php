<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';

    protected $fillable = ['id_categoria', 'nombre', 'descripcion', 'precio', 'stock'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria', 'id_categoria');
    }

    public function imagenes()
    {
        return $this->hasMany(ImagenProducto::class, 'id_producto', 'id_producto')
                    ->orderBy('orden');
    }

    // La primera imagen (orden más bajo), útil para tarjetas de producto
    public function imagenPrincipal()
    {
        return $this->hasOne(ImagenProducto::class, 'id_producto', 'id_producto')
                    ->orderBy('orden');
    }
}