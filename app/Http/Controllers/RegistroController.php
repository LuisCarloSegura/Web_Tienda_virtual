<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    /**
     * Muestra el formulario de registro de usuario.
     */
    public function mostrarFormulario()
    {
        return view('auth.registro');
    }

    /**
     * Valida y almacena un nuevo usuario registrado.
     */
    public function registrar(Request $solicitud)
    {
        $datosValidados = $solicitud->validate([
            'nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'regex:/@/',
                Rule::unique('users', 'email'),
                function ($atributo, $valor, $fallo) {
                    if (!str_contains($valor, '@')) {
                        $fallo('El correo electrónico debe contener el símbolo @.');
                    }
                },
            ],
            'password' => 'required|string|min:8|confirmed',
        ]);

        $datosValidados['password'] = Hash::make($datosValidados['password']);

        // RESTRICCIÓN DE SEGURIDAD: El registro público asigna obligatoria y únicamente el rol de 'cliente'.
        // Se prohíbe explícitamente el auto-registro de cuentas administradoras desde la web pública.
        $datosValidados['rol'] = 'cliente';

        $usuario = User::create($datosValidados);

        if ($solicitud->wantsJson()) {
            return response()->json([
                'mensaje' => 'Usuario registrado correctamente.',
                'usuario' => $usuario,
            ], 201);
        }

        return redirect()->to('/login')->with('exito', 'Usuario registrado correctamente.');
    }
}
