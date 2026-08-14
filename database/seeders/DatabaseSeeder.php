<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@technova.com'],
            [
                'nombre' => 'Administrador TechStore',
                'primer_apellido' => 'TechStore',
                'segundo_apellido' => 'CR',
                'password' => Hash::make('12345678'),
                'rol' => 'administrador',
            ]
        );

        User::updateOrCreate(
            ['email' => 'cliente@technova.com'],
            [
                'nombre' => 'Cliente de Prueba',
                'primer_apellido' => 'Prueba',
                'segundo_apellido' => 'TecnoNova',
                'password' => Hash::make('12345678'),
                'rol' => 'cliente',
            ]
        );

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
