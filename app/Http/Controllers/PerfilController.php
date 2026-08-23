<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    /**
     * Muestra la vista "Mi Cuenta" del perfil de usuario.
     */
    public function index()
    {
        $user = Auth::user();
        return view('client.perfil.index', compact('user'));
    }

    /**
     * Actualiza la información del perfil del usuario.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Reglas de validación para datos personales
        $rules = [
            'nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id_usuario, 'id_usuario'),
            ],
        ];

        $messages = [
            'nombre.required' => 'El nombre es obligatorio.',
            'primer_apellido.required' => 'El primer apellido es obligatorio.',
            'segundo_apellido.required' => 'El segundo apellido es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingrese un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado por otro usuario.',
            'password_actual.required' => 'Debe ingresar su contraseña actual.',
            'password.required' => 'Debe ingresar la nueva contraseña.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
        ];

        // Verificar si el usuario intenta cambiar la contraseña
        $quiereCambiarPassword = $request->filled('password_actual') || $request->filled('password') || $request->filled('password_confirmation');

        if ($quiereCambiarPassword) {
            $rules['password_actual'] = 'required|string';
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validatedData = $request->validate($rules, $messages);

        // Si intenta cambiar contraseña, validar que la contraseña actual coincida
        if ($quiereCambiarPassword) {
            if (!Hash::check($request->password_actual, $user->password)) {
                return back()
                    ->withErrors(['password_actual' => 'La contraseña actual ingresada es incorrecta.'])
                    ->withInput();
            }
        }

        // Actualizar datos personales directamente
        $user->nombre = $validatedData['nombre'];
        $user->primer_apellido = $validatedData['primer_apellido'];
        $user->segundo_apellido = $validatedData['segundo_apellido'];
        $user->email = $validatedData['email'];

        // Actualizar contraseña solo si fue provista y validada
        if ($quiereCambiarPassword) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', '¡Perfil actualizado con éxito!');
    }
}
