<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\ImagenProducto;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class TiendaSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Categorías principales (las del menú) =====
        $laptops   = Categoria::create(['nombre' => 'Laptops', 'slug' => 'laptops']);
        $celulares = Categoria::create(['nombre' => 'Celulares', 'slug' => 'celulares']);
        $audio     = Categoria::create(['nombre' => 'Audio', 'slug' => 'audio']);
        $tv        = Categoria::create(['nombre' => 'TV y proyección', 'slug' => 'tv-y-proyeccion']);

        //Productos de ejemplo
        $laptop1 = Producto::create([
            'id_categoria' => $laptops->id_categoria,
            'nombre' => 'Lenovo IdeaPad 1 – Ryzen 5 7520u – 8GB – 256GB – Abyss Blue',
            'descripcion' => 'Esta laptop es perfecta para estudiantes, ya que ofrece un equilibrio perfecto entre rendimiento y portabilidad. 
             Con su procesador AMD y gráficos integrados, gestiona tareas cotidianas como estudiar, ver contenido en streaming y navegar con facilidad. La pantalla FHD de 15.6″ garantiza imágenes nítidas, mientras que la pantalla antirreflejos reduce la fatiga visual.',
            'precio' => 349999.00,
            'stock' => 10,
        ]);

        ImagenProducto::create([
            'id_producto' => $laptop1->id_producto,
            'url_imagen' => 'images/productos/laptop1.jpg',
            'orden' => 0,
        ]);

        $celular1 = Producto::create([
            'id_categoria' => $celulares->id_categoria,
            'nombre' => 'Celular Ejemplo X',
            'descripcion' => 'Celular de ejemplo para pruebas, 128GB.',
            'precio' => 249999.00,
            'stock' => 15,
        ]);

        ImagenProducto::create([
            'id_producto' => $celular1->id_producto,
            'url_imagen' => 'https://via.placeholder.com/400x400?text=Celular',
            'orden' => 0,
        ]);
    }
}

