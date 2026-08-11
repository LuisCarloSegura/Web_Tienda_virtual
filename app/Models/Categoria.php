<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = ['nombre', 'slug', 'id_categoria_padre'];

    // Usa el slug en las URLs en vez del id (route model binding)
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function padre()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria_padre', 'id_categoria');
    }

    public function subcategorias()
    {
        return $this->hasMany(Categoria::class, 'id_categoria_padre', 'id_categoria');
    }

    public function esPrincipal(): bool
    {
        return is_null($this->id_categoria_padre);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_categoria', 'id_categoria');
    }
}