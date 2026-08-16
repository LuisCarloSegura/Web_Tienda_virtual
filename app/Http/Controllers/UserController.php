<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Muestra una lista de los usuarios.
     */
    public function listar(Request $solicitud)
    {
        $usuarios = User::all();

        if ($solicitud->wantsJson()) {
            return response()->json($usuarios);
        }

        return view('users.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function crear()
    {
        return view('users.create');
    }

    /**
     * Almacena un usuario recién creado en la base de datos.
     */
    public function guardar(Request $solicitud)
    {
        $datosValidados = $solicitud->validate([
            'nombre' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'primer_apellido' => 'required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
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
            'password' => 'required|string|min:8',
        ]);

        if (empty($datosValidados['nombre']) && empty($datosValidados['name'])) {
            $solicitud->validate([
                'nombre' => 'required|string|max:255',
            ]);
        }

        if (isset($datosValidados['name']) && !isset($datosValidados['nombre'])) {
            $datosValidados['nombre'] = $datosValidados['name'];
        } elseif (isset($datosValidados['nombre']) && !isset($datosValidados['name'])) {
            $datosValidados['name'] = $datosValidados['nombre'];
        }

        $datosValidados['password'] = Hash::make($datosValidados['password']);

        $usuario = User::create($datosValidados);

        if ($solicitud->wantsJson()) {
            return response()->json($usuario, 201);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el usuario especificado.
     */
    public function mostrar(Request $solicitud, $usuario)
    {
        $usuario = $usuario instanceof User ? $usuario : User::findOrFail($usuario);

        if ($solicitud->wantsJson()) {
            return response()->json($usuario);
        }

        return view('users.show', compact('usuario'));
    }

    /**
     * Muestra el formulario para editar el usuario especificado.
     */
    public function editar($usuario)
    {
        $usuario = $usuario instanceof User ? $usuario : User::findOrFail($usuario);

        return view('users.edit', compact('usuario'));
    }

    /**
     * Actualiza el usuario especificado en la base de datos.
     */
    public function actualizar(Request $solicitud, $usuario)
    {
        $usuario = $usuario instanceof User ? $usuario : User::findOrFail($usuario);

        $datosValidados = $solicitud->validate([
            'nombre' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'primer_apellido' => 'sometimes|required|string|max:255',
            'segundo_apellido' => 'nullable|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'string',
                'email',
                'regex:/@/',
                Rule::unique('users', 'email')->ignore($usuario->getKey(), $usuario->getKeyName()),
                function ($atributo, $valor, $fallo) {
                    if (!is_null($valor) && !str_contains($valor, '@')) {
                        $fallo('El correo electrónico debe contener el símbolo @.');
                    }
                },
            ],
            'password' => 'nullable|string|min:8',
        ]);

        if (isset($datosValidados['name']) && !isset($datosValidados['nombre'])) {
            $datosValidados['nombre'] = $datosValidados['name'];
        } elseif (isset($datosValidados['nombre']) && !isset($datosValidados['name'])) {
            $datosValidados['name'] = $datosValidados['nombre'];
        }

        if (!empty($datosValidados['password'])) {
            $datosValidados['password'] = Hash::make($datosValidados['password']);
        } else {
            unset($datosValidados['password']);
        }

        $usuario->update($datosValidados);

        if ($solicitud->wantsJson()) {
            return response()->json($usuario);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Elimina el usuario especificado de la base de datos.
     */
    public function eliminar(Request $solicitud, $usuario)
    {
        $usuario = $usuario instanceof User ? $usuario : User::findOrFail($usuario);

        $usuario->delete();

        if ($solicitud->wantsJson()) {
            return response()->json(['message' => 'Usuario eliminado correctamente.'], 200);
        }

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
