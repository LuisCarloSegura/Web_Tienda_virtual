<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Sembrar la base de datos de la aplicación con usuarios iniciales de prueba.
     */
    public function run(): void
    {
        // Creación obligatoria del usuario Administrador de prueba
        User::updateOrCreate(
            ['email' => 'admin@tienda.com'],
            [
                'nombre' => 'Administrador',
                'primer_apellido' => 'Sistema',
                'segundo_apellido' => 'Principal',
                'password' => Hash::make('12345678'),
                'rol' => 'administrador',
            ]
        );

        // Creación / actualización del usuario Cliente de prueba
        User::updateOrCreate(
            ['email' => 'cliente@tienda.com'],
            [
                'nombre' => 'Carlos',
                'primer_apellido' => 'Pérez',
                'segundo_apellido' => 'Gómez',
                'password' => Hash::make('12345678'),
                'rol' => 'cliente',
            ]
        );
    }
}
