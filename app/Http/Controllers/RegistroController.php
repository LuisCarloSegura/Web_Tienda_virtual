<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    public function mostrarFormulario()
    {
        return view('auth.register');
    }

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
                Rule::unique('users', 'email'),
            ],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'segundo_apellido.required' => 'El segundo apellido es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $datosValidados['password'] = Hash::make($datosValidados['password']);
        $datosValidados['rol'] = 'cliente';

        $usuario = User::create($datosValidados);

        if ($solicitud->wantsJson()) {
            return response()->json([
                'mensaje' => 'Usuario registrado exitosamente.',
                'usuario' => $usuario,
            ], 201);
        }

        return redirect()->route('login')->with('status', '¡Usuario registrado exitosamente! Ya puedes iniciar sesión.');
    }
}
